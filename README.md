KIXEYE
======

KIXEYE Coding Challenge

The public_html folder is currently live at the URL dustinhendricks.com/kixeye/public_html/ for you to try each file for yourself.

**RESTful API**

The RESTful API for posting a user score is available at the following location:

/public_html/user.php

It will expect a "signed_request" parameter, and a "score" parameter, in a POST request. It returns the result of the request as a JSON string. If the returned "error_code" parameter equals 0, then the request was successful.

You can test the user.php API by using the form on the page found at the URL dustinhendricks.com/kixeye/userTest.php.

**Schema for storing the data and score information**

You can find an SQL export of the used schema at the following location:

/spotless_kixeye(schema).sql

It is made up of two tables `users`, and `userScores`.

**Populate sample data**

The sample data population is available at the following location:

/public_html/generateSampleData.php

This script will first truncate the `users` and `userScores` tables, then populate them again with random data. It uses prepared PDO statements for caching, but still takes a while to run. It will create 1000 users, with 999 score records each. The dates will be random dates picked from the past 30 days.

**Generate user report**

The user report is available at the following location:

/public_html/userReport.php

The report is currently unstyled. Let me know if you would like me to style it for ease of reading.
