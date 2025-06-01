// 随机生成颜色
function randomColor() {
  return '#' + Math.floor(Math.random()*0xFFFFFF).toString(16).padStart(6, '0');
}

window.addEventListener('DOMContentLoaded', function () {
  var c1 = randomColor();
  var c2 = randomColor();
  document.documentElement.style.setProperty('--page-bg', 'linear-gradient(135deg, ' + c1 + ', ' + c2 + ')');
});
