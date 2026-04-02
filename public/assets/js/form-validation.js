document.getElementById('notify').addEventListener('click', function (event) {
    var name = document.getElementById('popup_name').value;
    var email = document.getElementById('popup_email').value;

    if (name.trim() === '' || email.trim() === '' || !validateEmail(email)) {
      event.preventDefault();
      alert('Please fill in all fields with valid data.');
    }
  });



  document.getElementById('contact_submit').addEventListener('click', function (event) {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var message = document.getElementById('message').value;
    var word = document.getElementById('word').value;

    if (name.trim() === '' || email.trim() === '' || !validateEmail(email) || phone.trim() === '' || message.trim() === '' || word.trim() === '') {
      event.preventDefault();
      alert('Please fill in all fields with valid data.');
    }
  });

  function validateEmail(email) {
    // Use a regular expression to validate the email format
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
  }



