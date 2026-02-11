
// --- AUTH ---
function handleAuth(type) {
    let user, pass;
    if (type === 'login') {
        user = document.getElementById('login-user').value;
        pass = document.getElementById('login-pass').value;
    } else {
        user = document.getElementById('reg-user').value;
        pass = document.getElementById('reg-pass').value;
    }

    if(!user || !pass) return alert("Credentials required!");
    
    let fd = new FormData();
    fd.append('action', type); 
    fd.append('username', user); 
    fd.append('password', pass);

    fetch('auth.php', { method: 'POST', body: fd }).then(res => res.text()).then(data => {
        if (data.trim() === "success") {
            setCookie('loggedUser', user, 7);
            currentAgent = user;
            if (type === 'register') {
                alert("Account Created! Welcome to the mission, Agent " + user);
            }
            showMainMenu();
        } else {
            alert(data);
        }
    });
}
