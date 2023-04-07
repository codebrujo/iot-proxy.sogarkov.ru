document.addEventListener('DOMContentLoaded', function() {
  var typed = new Typed('#typed6', {
    strings: ['Приветствую вас, уважаемый посетитель!'],
    typeSpeed: 60,
    backSpeed: 0,
    startDelay: 1000,
    backDelay: 5000,
    showCursor: false,
    loop: false
  });
    typed = new Typed('#typed6', {
    //strings: ['loading page...^2000\n`installing components...` ^2000\n`Fetching from source...`'],
    strings: ['Вы находитесь на домашней странице Сергея Огаркова.<br>Здесь размещена информация о сфере моей профессиональной<br>деятельности и основных компетенциях.'],
    typeSpeed: 80,
    backSpeed: 0,
    startDelay: 6000,
    backDelay: 14000,
    showCursor: true,
    loop: true,
    loopCount: Infinity,
    onComplete: function(self) { prettyLog('onComplete ' + self) },
  });
});

function prettyLog(str) {
  console.log('%c ' + str, 'color: green; font-weight: bold;');
}

function toggleLoop(typed) {
  if (typed.loop) {
    typed.loop = false;
  } else {
    typed.loop = true;
  }
}
