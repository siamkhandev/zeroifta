importScripts('https://www.gstatic.com/firebasejs/9.15.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.15.0/firebase-messaging-compat.js');

// Your Firebase project configuration
const firebaseConfig = {
  apiKey: "AIzaSyCKydVjKzwlLemInyUL0wumXBI1aOylVrc",
  authDomain: "zeroifta-4d9af.firebaseapp.com",
  projectId: "zeroifta-4d9af",
  storageBucket: "zeroifta-4d9af.appspot.com",
  messagingSenderId: "47332106822",
  appId: "1:47332106822:web:69ec62c4634d6a776a2047",
  measurementId: "G-NMWV5VXQ00"
};

// Initialize Firebase app
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage(function (payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  
  const notificationTitle = payload.notification?.title || 'Notification Title';
  const notificationOptions = {
    body: payload.notification?.body || 'Notification body text',
    icon: '/path-to-your-icon.png'
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
