function imagesvideosFancybox(){
  $('a[data-fancybox="imagesvideo"]').fancybox({
    loop    : false,
    arrows  : false,
    infobar : false,
    margin  : [44,0,22,0],
    buttons : [
      'arrowLeft',
      'counter',
      'arrowRight',      
      'close',
    ],
    thumbs : {
      autoStart : true,
      axis : 'x',
    },
  });
}