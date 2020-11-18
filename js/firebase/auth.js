// Firebase Authentication
const auth = firebase.auth();
const db = firebase.firestore();
// Listen for auth status changes
var uid = -1;
auth.onAuthStateChanged((user) => {
  console.log(user);
  if (user) {
    uid = user.uid;
    console.log(user.uid);
    console.log("Logged in");
  } else {
    console.log("Logged out");
  }
});
/*
// Logged in vs. logged out
const loggedOutLinks = document.querySelectorAll(".loggedOut");
const loggedInLinks = document.querySelectorAll(".loggedIn");
const loggedBothLinks = document.querySelectorAll(".loggedBoth");
const setup = (user) => {
  if (user) {
    loggedOutLinks.forEach((item) => (item.style.display = "none"));
    loggedInLinks.forEach((item) => (item.style.display = "inline-block"));
    loggedBothLinks.forEach((item) => (item.style.display = "inline-block"));
  } else {
    loggedOutLinks.forEach((item) => (item.style.display = "inline-block"));
    loggedInLinks.forEach((item) => (item.style.display = "none"));
    loggedBothLinks.forEach((item) => (item.style.display = "inline-block"));
  }
};
// Sign Up
if ($("#signUpForm").length) {
  const signUpForm = document.querySelector("#signUpForm");
  signUpForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const email = signUpForm["email"].value;
    const password = signUpForm["password"].value;
    auth.createUserWithEmailAndPassword(email, password).then((cred) => {
      signUpForm.reset();
    });
  });
}
// Log In
if ($("#loginForm").length) {
  const loginForm = document.querySelector("#loginForm");
  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const email = loginForm["email"].value;
    const password = loginForm["password"].value;
    auth.signInWithEmailAndPassword(email, password).then((cred) => {
      loginForm.reset();
    });
  });
}
// Log Out
if ($("#logoutButton").length) {
  const logout = document.querySelector("#logoutButton");
  logout.addEventListener("click", (e) => {
    e.preventDefault();
    auth.signOut();
  });
}

.then((cred) => {
    return db.collection("users").doc(cred.user.uid).set({
      plaid: null,
    });

    
*/
// Sign Up
function signUp() {
  const email = $("#email").val();
  const password = $("#password").val();
  auth.createUserWithEmailAndPassword(email, password).then((cred) => {
    return db.collection("users").doc(cred.user.uid).set({
      email: email,
    });
  });
}
// Log In
async function logIn() {
  const email = $("#email").val();
  const password = $("#password").val();
  await auth.signInWithEmailAndPassword(email, password);
}
// Log Out
async function logOut() {
  await auth.signOut();
}