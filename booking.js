document.addEventListener("DOMContentLoaded", function () {
  // Initialize the last reference number

  // Function to generate sequential booking reference
  function generateBookingReference() {
    return result;
  }

  var bookingform = document.getElementById("bookingform");
  if (!bookingform) {
    console.error("Booking form element not found.");
    return;
  }

  bookingform.addEventListener("submit", function (event) {
    event.preventDefault();

    // Validate inputs
    var cname = document.getElementById("cname").value;
    var phone = document.getElementById("phone").value;
    var unumber = document.getElementById("unumber").value;
    var snumber = document.getElementById("snumber").value;
    var stname = document.getElementById("stname").value;
    var sbname = document.getElementById("sbname").value;
    var dsbname = document.getElementById("dsbname").value;
    var pick_up_date = document.getElementById("pick_up_date").value;
    var pick_up_time = document.getElementById("pick_up_time").value;

    var lastReferenceNumber = 1;
    var result = "";
    $.get("../../~rzn5038/assign2/get_lastreference.php", function (response) {
      if (response.error) {
        lastReferenceNumber = 1;
        const reference = "BRN";
        const formattedNumber = lastReferenceNumber.toString().padStart(5, "0");
        const bookingReference = reference + formattedNumber;
        result = bookingReference;
      } else {
        lastReferenceNumber =
          response.bookingform[0].bookingreference.split("BRN")[1];
        lastReferenceNumber = Number(lastReferenceNumber) + 1;
        const reference = "BRN";
        const formattedNumber = lastReferenceNumber.toString().padStart(5, "0");
        const bookingReference = reference + formattedNumber;
        result = bookingReference;
      }
      var bookingreference = result;
      // Check if required fields are filled in
      if (
        !cname ||
        !phone ||
        !snumber ||
        !stname ||
        !pick_up_date ||
        !pick_up_time
      ) {
        alert("Please fill in all required fields.");
        return;
      }

      // Check if phone number is valid
      if (!/^[0-9]{10,12}$/.test(phone)) {
        alert("Please enter a valid phone number with 10-12 digits.");
        return;
      }

	

      // Convert date and time to ISO format
      var datetime = new Date(pick_up_date + "T" + pick_up_time);
      // Check if pick-up date and time are in the future
      if (datetime < new Date()) {
        alert("Please enter a pick-up date and time that is in the future.");
        return;
      }

      // Send booking request to server using fetch API
      fetch("../../~rzn5038/assign2/booking.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          bookingreference: bookingreference,
          cname: cname,
          phone: phone,
          unumber: unumber,
          snumber: snumber,
          stname: stname,
          sbname: sbname,
          dsbname: dsbname,
          pick_up_date: datetime.toISOString().split("T")[0],
          pick_up_time: datetime.toTimeString().split(" ")[0],
          status: "unassigned",
        }),
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (data) {
          console.log(bookingreference);
          document.getElementById("message").innerHTML += data;
        });
    });
  });
});
