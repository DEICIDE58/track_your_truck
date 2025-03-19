
      // Replace with your actual API key
      const API_KEY = "INSERT_YOUR_API_KEY";

      // Input parameter (either address or video ID)
      const PARAMETER_VALUE = "1600 Amphitheatre Parkway, Mountain View, CA 94043";

      async function initAerialView() {
        const videoElement = document.getElementById("video");

        // Toggle play/pause when the video is clicked
        videoElement.addEventListener("click", () => {
          if (videoElement.paused) {
            videoElement.play();
          } else {
            videoElement.pause();
          }
        });

        try {
          // Determine if input is video ID or address
          const parameterKey = videoIdOrAddress(PARAMETER_VALUE);
          const urlParameter = new URLSearchParams();
          urlParameter.set(parameterKey, PARAMETER_VALUE);
          urlParameter.set("key", API_KEY);

          const response = await fetch(
            `https://aerialview.googleapis.com/v1/videos:lookupVideo?${urlParameter.toString()}`
          );

          if (!response.ok) {
            throw new Error(`Error: ${response.status} ${response.statusText}`);
          }

          const videoResult = await response.json();

          if (videoResult.state === "PROCESSING") {
            alert("Video is still processing. Please try again later.");
          } else if (videoResult.error && videoResult.error.code === 404) {
            alert("Video not found. You may need to generate the video.");
          } else {
            // Set the video source
            videoElement.src = videoResult.uris.MP4_MEDIUM.landscapeUri;
          }
        } catch (error) {
          console.error("Failed to fetch video data:", error);
          alert("An error occurred while fetching the video. Please check the console for details.");
        }
      }

      // Check if the input is a video ID or an address
      function videoIdOrAddress(value) {
        const videoIdRegex = /^[0-9a-zA-Z-_]{22}$/;
        return videoIdRegex.test(value) ? "videoId" : "address";
      }

      initAerialView();