"use strict";

// buttons
//let callbtn = document.querySelector("#callBtn");
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
};

$("#callBtn").on("click", (e) => {
  WRTCStage.getCamera();
});

let conn = new WebSocket(`ws://localhost:8091?token=${token}`);

conn.onopen = function (e) {
  console.log("Connected to WebSocket!");
};

conn.onmessage = function (e) {
  console.log(e.data);
};

conn.send(
  JSON.stringify({
    type: "is-client-is-ready",
    data: null,
    sendTo: sendTo,
  })
);

// function sendSocket(type, data, sendTo) {
//   conn.send(
//     JSON.stringify({
//       sendTo: sendTo,
//       type: type,
//       data: data,
//     })
//   );
// }

// sendSocket("is-client-is-ready", null, sendTo);
