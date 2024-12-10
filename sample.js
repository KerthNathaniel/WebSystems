const formContainer = document.querySelector('.formContainer');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

if (formContainer && loginLink && registerLink){

registerLink.addEventListener('click', ()=> {
    formContainer.classList.add('active');
})

loginLink.addEventListener('click', ()=> {
    formContainer.classList.remove('active');
})
}
else{
    console.error('Some elements are missing!')
}