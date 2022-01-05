const email = document.getElementById("email");
const password = document.getElementById("pass");
const isVilible = document.getElementById("visibility");

// Errors input
const globalError = document.getElementById("global-error");
const emailError = document.getElementById("email-error");
const passError = document.getElementById("pass-error");

function validateForm() {
  const emailRegEx =
    /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;

  const passRegEx =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

  if (!email.value || !password.value) {
    globalError.innerText = "Preencha devidamente os campos";

    return false;
  } else {
    globalError.innerText = "";
  }

  if (!emailRegEx.exec(email.value)) {
    emailError.innerText = `Email inválido, tente outro`;

    return false;
  } else {
    emailError.innerText = "";
  }

  if (!passRegEx.exec(password.value)) {
    passError.innerText = `No mínimo oito caracteres, pelo menos uma letra maiúscula, uma
    letra minúscula, um número e um caractere especial ex:
    @$!%*?&.`;

    return false;
  } else {
    passError.innerText = "";
  }
}

isVilible.addEventListener("click", () => {
  if (isVilible.checked) {
    password.type = "text";
  } else {
    password.type = "password";
  }
});
