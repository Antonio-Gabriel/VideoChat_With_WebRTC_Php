"use strict";

// buttons
let callbtn = $("#callBtn");
let callBox = $("#callBox");

let answerBtn = $("#answerBtn");
let declineBtn = $("#declineBtn");

const token = document.querySelector(".token").innerText;

let pc;
let sendTo = callbtn.data("user");
let localStream;

// video element
const localvideo = document.querySelector("#localVideo");
const remotevideo = document.querySelector("#remoteVideo");

const mediaConst = {
  fake: true,
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
      localStream = mediaStream;
      localStream.getTracks().forEach((track) => {
        pc.addTrack(track, localStream);
      });

      localvideo.srcObject = localStream;

      console.log(localStream);
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

  // Create Answer
  async createAnswer(sendTo, data) {
    if (!pc) {
      await WRTCStage.getConnection();
    }

    if (!localStream) {
      await WRTCStage.getCamera();
    }

    await sendIceCandidate(sendTo);
    await pc.setRemoteDescription(data);
    await pc.createAnswer();
    await pc.setLocalDescription(pc.localDescription);

    send("client-answer", pc.localDescription, sendTo);
  },
};

$("#callBtn").on("click", (e) => {
  WRTCStage.getCamera();

  $("#call").addClass("hidden");
  $("#video").removeClass("hidden");
  //send("is-client-ready", null, sendTo);
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

  // Change data on front
  $("#username").text(username);
  $("#profile_image").attr("src", `./assets/images/${profile_image}`);

  switch (type) {
    case "client-candidate":
      if (pc.localDescription) {
        await pc.addIceCandidate(new RTCIceCandidate(data));
      }
      break;

    case "is-client-ready":
      if (!pc) {
        await WRTCStage.getConnection();
      }

      if (pc.iceConnectionState === "connected") {
        send("client-already-oncall");
      } else {
        // display
        displayCall();

        answerBtn.on("click", () => {
          callBox.addClass("hidden");

          send("client-is-ready", null, sendTo);
        });

        declineBtn.on("click", () => {
          send("client-rejected", null, sendTo);
          location.reload(true);
        });
      }
      break;

    case "client-is-ready":
      WRTCStage.createOffer(sendTo);
      break;

    case "client-answer":
      if (pc.localDescription) {
        await pc.setRemoteDescription(data);
      }
      break;

    case "client-offer":
      await WRTCStage.createAnswer(sendTo, data);
      break;

    case "client-already-oncall":
      // display popup right here
      setTimeout("window.location.reload(true)", 2000);

      break;

    case "client-rejected":
      alert("O número está ocupado de momento");
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

    pc.ontrack = (e) => {
      // Configure permition to Open the camera

      $("#call").addClass("hidden");
      $("#video").removeClass("hidden");

      console.log(e.streams);

      //remotevideo.srcObject = e.streams[0];
    };
  };
}

function displayCall() {
  callBox.removeClass("hidden");
}
