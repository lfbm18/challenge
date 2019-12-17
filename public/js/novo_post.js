$(document).ready(function(){
    $("#insere-descricao").on("keydown", autosize);
});

function autosize(){
    var element = this;
    setTimeout(function(){
      element.style.cssText = 'height:auto; padding:0';
      element.style.cssText = 'height:' + element.scrollHeight + 'px';
    },0);
}

