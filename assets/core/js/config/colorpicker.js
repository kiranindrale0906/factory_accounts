function colorpicker(){
  if ($('.colorpicker_js').length>0) {
    var picker = new CP(document.querySelector('.colorpicker_js')),
        box = document.createElement('span'),
        a = document.createElement('span'),
        b = document.createElement('span');

    box.className = 'color-view';
    box.appendChild(a);
    box.appendChild(b);
    picker.self.appendChild(box);

    picker.on("enter", function() {
        var color = '#' + CP._HSV2HEX(this.get());
        a.title = color;
        b.title = color;
        a.style.backgroundColor = color;
        b.style.backgroundColor = color;
    });

    picker.on("change", function(color) {
        b.title = '#' + color;
        b.style.backgroundColor = '#' + color;
    });

    // click to reset
    a.addEventListener("click", function(e) {
        var color = this.title;
        picker.set(color);
        b.title = color;
        b.style.backgroundColor = color;
        e.stopPropagation();
    }, false);

    // click to set
    b.addEventListener("click", function(e) {
        var color = this.title;
        picker.exit();
        picker.source.value = color;
        picker.source.focus();
    }, false); 
  }
  
}