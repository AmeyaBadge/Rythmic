const signUpButton =document.getElementById('signUp')
        const signInButton =document.getElementById('signIn')
        const UpButton =document.getElementById('up-btn')
        const InButton =document.getElementById('in-btn')
        const main =document.getElementById('main')

        signInButton.addEventListener('click', ()=>{
            main.classList.remove("right-panel-active");
            
        });
        signUpButton.addEventListener('click', ()=>{
            main.classList.add("right-panel-active");
        });
        UpButton.addEventListener('click', ()=>{
            // e.preventDefault(); 
            window.location.href = 'logged.html'
        });
        InButton.addEventListener('click', ()=>{
            // e.preventDefault(); 
            window.location.href = 'logged.html'
        });
// window.location.href = 'logged.html'