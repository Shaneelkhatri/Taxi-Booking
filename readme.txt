COMP721-Assignment-2

Files

Admin.html - Contains the frontend code for the html page for searching and viewing booking information
Admin.js - This manages the function called searchbooking() when the search button is clicked it fetches from the php script based on the booking reference number.
Admin.php - This connects to the database and handles search requests for booking information bases on the reference number and fetches data from the bookingform and returns it in JSON responses. 
            If there are no booking reference provided it shows all the unassigned bookings.
Assign.php - This script updates the status of a booking to assigned based on the booking reference number.

booking.html - This is the frontend code for the html page when entering taxi booking data of the customers information and provides a booking reference at the end.
booking.js - This handles the form submission and fetches the last booking reference number from the server and generates a new booking number, validating user inputs and sending the booking request to the server.
booking.php - This script recieves data for a booking and inserts it into a database table called bookingform and displays a confirmation message with booking details if successful.
              If the bookingform table does not exist it creates it first and if there are any errors during this proccess an error message is displayed.

get_lastreference.php - This connects to the database and fetches booking information from the bookingform table. It gets data in a descending order and if successful returns a JSON response containing the booking information. 
search.php - This connects to the database and fetches a post parameter named bsearch for a booking reference number.
style.css - This is used for the styling of the website for the admin.html and booking.html

sql.txt - This contains all my sql codes used in the assignment.
jqery-3.7.1.min.js - This is the jquery library that is used in this assignment


To use this open booking.html 
Enter Information 
click submit, you will recieve information below about your booking confirmation 

To search for you booking use admin.html and enter your booking number. 