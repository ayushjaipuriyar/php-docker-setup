// const signUpButton = document.getElementById('signUp');
// const signInButton = document.getElementById('signIn');
// const container = document.getElementById('container');

// signUpButton.addEventListener('click', () => {
// 	container.classList.add('right-panel-active');
// });

// signInButton.addEventListener('click', () => {
// 	container.classList.remove('right-panel-active');
// });

const greeting = document.getElementById('greeting');
const hour = new Date().getHours();
const welcomeTypes = ['Good morning', 'Good afternoon', 'Good evening'];
let welcomeText = '';
if (hour < 12) welcomeText = welcomeTypes[0];
else if (hour < 18) welcomeText = welcomeTypes[1];
else welcomeText = welcomeTypes[2];
greeting.innerHTML = welcomeText;
