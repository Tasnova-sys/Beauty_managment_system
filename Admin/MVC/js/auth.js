document.getElementById('registerForm').addEventListener('submit', function(e) {

    const password = document.getElementById('password').value;
    
    const confirmPassword = document.getElementById('confirm_password').value;



    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert("Passwords do not match.");

        return false;
    }
if(password.length <6){
    e.preventDefault();
    alert('password should be 6 character');
    return false;
}



});