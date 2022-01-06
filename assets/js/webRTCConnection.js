"use strict";

// buttons
let callbtn = $("#callBtn");
const token = document.querySelector(".token").innerText;

let pc;
let sendTo = callbtn.data("user");
let localStream;

// video element
const localvideo = document.querySelector("#localVideo");
const remotevideo = document.querySelector("#remoteVideo");

const mediaConst = {
  video: true,
};

// Recive from other client
const options = {
  offerToReciveVideo: 1,
};

const WRTCStage = {
  getConnection() {
    if (!pc) {
      pc = new RTCPeerConnection();
    }
  },

  // ask for media input
  async getCamera() {
    let mediaStream;
    try {
      if (!pc) {
        await this.getConnection();
      }

      mediaStream = await navigator.mediaDevices.getUserMedia(mediaConst);
      localvideo.srcObject = mediaStream;
      localStream = mediaStream;
      localStream.getTracks().forEach((track) => {
        pc.addTrack(track, localStream);
      });
    } catch (error) {
      console.log(error);
    }
  },

  // createOffer
  async createOffer(sendTo) {
    await sendIceCandidate(sendTo);
    await pc.createOffer(options);
    await pc.setLocalDescription(pc.localDescription);

    send("client-offer", pc.localDescription, sendTo);
  },
};

$("#callBtn").on("click", (e) => {
  WRTCStage.getCamera();

  send("is-client-ready", null, sendTo);
});

let conn = new WebSocket(`ws://localhost:8088?token=${token}`);

conn.onopen = function (e) {
  console.log("Connected to WebSocket!");
};

conn.onmessage = async function (e) {
  let message = JSON.parse(e.data);

  // Json response
  let by = message.by;
  let data = message.data;
  let type = message.type;
  let username = message.username;
  let profile_image = message.profile_image;

  switch (type) {
    case "is-client-ready":
      if (!pc) {
        await WRTCStage.getConnection();
      }

      if (pc.iceConnectionState === "connected") {
        send("client-already-oncall");
      } else {
        // display
        alert("Chamando!...");
      }
      break;

    case "client-already-oncall":
      // display popup right here
      setTimeout("window.location.reload(true)", 2000);

      break;
  }
};

function send(type, data, sendTo) {
  conn.send(
    JSON.stringify({
      type: type,
      data: data,
      sendTo: sendTo,
    })
  );
}

send("is-client-is-ready", null, sendTo);

function sendIceCandidate(sendTo) {
  pc.onicecandidate = (e) => {
    if (e.candidate !== null) {
      // send to other candinate

      send("client-candidate", e.candidate, sendTo);
    }
  };
}
