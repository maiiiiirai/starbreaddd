const loginForm = document.getElementById('loginForm');
const username = document.getElementById('username');
const password = document.getElementById('password');

loginForm.addEventListener('submit', async function(event) {
    event.preventDefault(); 

    const formData= new FormData();
    formData.append('username', username.value);
    formData.append('password', password.value);

    try {
      const response = await fetch ('../../../../backend/auth/login.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.success) {
        alert( result.message);
        window.location.href = '../../../../frontend/pages/home-page.php';
      } else {
        alert( result.message);
      }
    } catch (error) {
      console.error('Error:', error);
    }
  });