<?php
class CSSlowLogRoute extends CFileLogRoute {
	/**
	 * @var boolean whether to aggregate results according to profiling tokens.
	 * If false, the results will be aggregated by categories.
	 * Defaults to true. Note that this property only affects the summary report
	 * that is enabled when {@link report} is 'summary'.
	 */
	public $groupByToken = true;
	
	public $logSlow = 3;
	public $logFrequent = 3;

	/**
	 * Initializes the route.
	 * This method is invoked after the route is created by the route manager.
	 */
	public function init() {
		parent::init();
		$this->levels = CLogger::LEVEL_PROFILE;
	}

	/**
	 * Store log messages.
	 * @param array $logs list of log messages
	 */
	protected function processLogs( $logs ) {
		$app = Yii::app();
		if( !( $app instanceof CWebApplication ) || $app->getRequest()->getIsAjaxRequest() ) {
			return;
		}

		$stack = array();
		foreach( $logs as $log ) {
			if( $log[1] !== CLogger::LEVEL_PROFILE ) {
				continue;
			}
			$message = $log[0];
			if( !strncasecmp( $message, 'begin:', 6 ) ) {
				$log[0] = substr( $message, 6 );
				$stack[] = $log;
			} elseif( !strncasecmp( $message, 'end:', 4 ) ) {
				$token = substr( $message, 4 );
				if( ( $last = array_pop( $stack ) ) !== null && $last[0] === $token ) {
					$delta = $log[3] - $last[3];
					if( !$this->groupByToken ) {
						$token = $log[2];
					}
					if( isset( $results[$token] ) ) {
						$results[$token] = $this->aggregateResult( $results[$token], $delta );
					} else {
						$results[$token] = array( $token, 1, $delta, $delta, $delta );
					}
				} else {
					throw new CException( Yii::t( 'yii', 'CSSlowLogRoute found a mismatching code block "{token}". Make sure the calls to Yii::beginProfile() and Yii::endProfile() be properly nested.',
						array( '{token}'=>$token ) ) );
				}
			}
		}

		$now = microtime( true );
		while( ( $last = array_pop( $stack ) ) !== null ) {
			$delta = $now - $last[3];
			$token = $this->groupByToken ? $last[0] : $last[2];
			if( isset( $results[$token] ) ) {
				$results[$token] = $this->aggregateResult( $results[$token], $delta );
			} else {
				$results[$token] = array( $token, 1, $delta, $delta, $delta );
			}
		}

		$logFile = $this->getLogPath() . DIRECTORY_SEPARATOR . $this->getLogFile();
		if( @filesize( $logFile ) > $this->getMaxFileSize() * 1024 ) {
			$this->rotateFiles();
		}
		$fp = @fopen( $logFile, 'a' );
		if( $fp ) {
			@flock( $fp, LOCK_EX );
			foreach( $results as $entry ) {
				if( $entry[4] >= $this->logSlow || $entry[1] >= $this->logFrequent ) {
					$min = sprintf( '%0.5f', $entry[2] );
					$max = sprintf( '%0.5f', $entry[3] );
					$total = sprintf( '%0.5f', $entry[4] );
					$average = sprintf( '%0.5f', $entry[4] / $entry[1] );
					$msg = 'Procedure: ' . $entry[0] . '; Count: ' . $entry[1] . '; Total: ' . $total . '; Min: ' . $min . '; Max: ' . $max . '; Average: ' . $average;
					fwrite( $fp, $this->formatLogMessage( $msg, 'warning', 'slowlog', time() ) );
				}
			}
			@flock( $fp, LOCK_UN );
			@fclose( $fp );
		}
	}

	/**
	 * Aggregates the report result.
	 * @param array $result log result for this code block
	 * @param float $delta time spent for this code block
	 * @return array
	 */
	protected function aggregateResult( $result, $delta ) {
		list( $token, $calls, $min, $max, $total ) = $result;
		if( $delta < $min ) {
			$min = $delta;
		} elseif( $delta > $max ) {
			$max = $delta;
		}
		$calls++;
		$total += $delta;
		return array( $token, $calls, $min, $max, $total );
	}
}