var BackendUploadedFiles = BackendUploadedFiles ||
 {
   files: [],
   getImages: function() {
     var res = [];
     for (var i in this.files) {
       if (/(\.jpe?g|bmp|png|gif)$/i.test(this.files[i].name)) {
         res.push(this.files[i]);
       }
     }
     return res;
   },
   add: function(file) {
     this.files.push(file);
   },
   addList: function(list) {
     this.files = this.files.concat(list);
   },
   remove: function(id) {
     var afterRemove = [];
     for (var i in this.files) {
       if (this.files[i].fileId == id) {
         continue;
       }
       afterRemove.push(this.files[i]);
     }
     this.files = afterRemove;
   }
 }