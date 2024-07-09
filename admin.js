function searchBooking() {
  let bookingreference = document.getElementById("bookingreference").value;
  const resultsDiv = document.getElementById("bookinginfo");

  console.log("Searching for booking reference:", bookingreference);

  fetch(
    "../../~rzn5038/assign2/admin.php?bsearch=" + encodeURIComponent(bookingreference)
  )
    .then((response) => {
      console.log("Response status:", response.status);
      if (!response.ok) {
        throw new Error("The network response was not ok.");
      }
      return response.text();
    })
    .then((data) => {
      let jsonString = data.substring(data.indexOf("{"), data.length);
      try {
        let jsonData = JSON.parse(jsonString);
        console.log(jsonData);
      } catch (e) {
        console.error("Failed to parse JSON:", e);
      }
      jsonData = JSON.parse(jsonString);
      console.log("Response data:", jsonData);
      console.log(jsonData.bookingform);
      if (jsonData.error) {
        resultsDiv.textContent = jsonData.error;
      } else if (jsonData.bookingform) {
        var txt = "";
        for (c in jsonData.bookingform) {
          txt +=
            "<tr>" +
            "<td id='booking_reference_" +
            c +
            "'>" +
            jsonData.bookingform[c].bookingreference +
            "</td>" +
            "<td>" +
            jsonData.bookingform[c].cname +
            "</td>" +
            "<td>" +
            jsonData.bookingform[c].phone +
            "</td>" +
            "<td>" +
            jsonData.bookingform[c].sbname +
            "</td>" +
            "<td>" +
            jsonData.bookingform[c].dsbname +
            "</td>" +
            "<td>" +
            jsonData.bookingform[c].pick_up_date +
            " " +
            jsonData.bookingform[c].pick_up_time +
            "</td>" +
            "<td id='assign_td_" +
            c +
            "'>" +
            jsonData.bookingform[c].status +
            "</td>" +
            "<td>" +
            "<button class='assign-btn' id='assign_btn_" +
            c +
            "'>Assign</button>" +
            "</td>" +
            "</tr>";
        }

        $("#tbody")[0].innerHTML = txt;
        $('#view_table').removeClass("hidden");
        $('#view_error').addClass("hidden");
      } else {
        $('#view_error').removeClass("hidden");
        $('#view_table').addClass("hidden");
      }

      // Adding event listeners for assign buttons after updating the DOM
      addAssignButtonEventListeners();
    })
    .catch((error) => {
      console.error("Error:", error);

      resultsDiv.textContent = "Error loading bookings: " + error.message;
    });
}

// Function to add event listeners for assign buttons
function addAssignButtonEventListeners() {
  $(document).off("click", ".assign-btn"); // Remove existing event listeners to avoid duplicates
  $(document).on("click", ".assign-btn", function () {
    let id = $(this)[0].id.split("_")[$(this)[0].id.split("_").length - 1];
    let booking_reference = $("#booking_reference_" + id)[0].innerHTML;
    let assignButton = $(this);

    // Disable the button
    assignButton.prop("disabled", true);

    $.post(
      "../../~rzn5038/assign2/assign.php",
      { bsearch: booking_reference },
      function (response) {
        console.log(response);
        if (response.success === "success") {
          $("#assign_td_" + id)[0].innerHTML = "assigned";
          assignButton.addClass("assigned"); 
        }
      }
    );
  });
}
