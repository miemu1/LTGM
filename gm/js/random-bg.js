(function(){
  function randColor(){
    return '#' + Math.floor(Math.random()*0xffffff).toString(16).padStart(6,'0');
  }
  var c1 = randColor();
  var c2 = randColor();
  document.body.style.background = 'linear-gradient(45deg,'+c1+','+c2+')';
})();
