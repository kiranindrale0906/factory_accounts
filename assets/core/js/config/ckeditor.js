function ckeditor(){
  $('.ckeditor_js').each(function(e){
    if (CKEDITOR.instances[this.id]) {
      CKEDITOR.instances[this.id].destroy(true);
    }
    editor=CKEDITOR.replace( this.id, {
    toolbar: [
    { name: 'all', items: ['Bold','Italic','Underline','BulletedList','Maximize','SuperButton', 'save'] },

    ]
  });
  editor.addCommand("mySimpleCommand", {
      exec: function(edt) {
          alert(edt.getData());
      }
  });
    editor.ui.addButton('SuperButton', {
       // items:'asdsdsdsds',
        label: 'Click to Save',
        command: 'mySimpleCommand',
        toolbar: 'insert',
        icon: 'https://dabuttonfactory.com/button.png?t=SAVE&f=Calibri-Bold&ts=20&tc=fff&tshs=1&tshc=000&hp=10&vp=5&c=0&bgt=unicolored&bgc=216be9'
    });
  });
}
function add_ckeditor_configuration() {
  $('.custom_ckeditor_js').each(function(e){
    editor=CKEDITOR.replace( this.id, {
            "language": "en",
           customConfig: '',
           extraPlugins  :'',
           toolbar : [
                      { 'name': 'tools', 'items': [ 'Maximize', 'ShowBlocks' ] },
                    ],
          removeButtons : 'Save,Preview,NewPage,Print,Templates,Cut,PasteText,PasteFromWord,Paste,Copy,Redo,Undo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,BidiLtr,BidiRtl,Language,Flash,Table,HorizontalRule,PageBreak,Iframe,ShowBlocks,About,Smiley,SpecialChar,Anchor,CopyFormatting, RemoveFormat,Subscript,Superscript',
          disallowedContent : 'img{border*,margin*}; table[border]{*}',
          startupMode : 'source',
       });
  });
}