Name: Kacey Ryan
UID: 604047388
Project 1C

Everything was done as described in the spec.

The layout of my src/ directory is as follows:

index.php - aptly named as it is the homepage and directs to every other portion of my web page. It actually has no php, only html but I didn't rename it. There are five links that point to the five other files in the directory.

input.php - This page handles all input apart from review input. It fetches most movie ids based on the title of the movie. If there is ever a duplicate title, it will prompt you with a choice of which title you actually meant supplied with other information from the movie table. The only portion of my part B lab that I had to change was changing the PRIMARY KEY of MovieGenre to have both mid and genre so that way one movie could have multiple genres.

search.php - This is my search page. I have a radio button that allows you to switch from SPACE being ORs and ANDs. This allows for versatile functionality. My searches are done using LIKE to check if the search string is a substring. To start I split the search string at its spaces, then I loop through each search keyword and add it to both the AND and OR query. The results link to the detail pages of browseA.php and browseM.php

browseA.php - This is my Actor browse or detail page. If it is visited on its own then it will initially prompt you for a name and search for it. It will bring you to the browse page of a specific actor where it displays the fields from the actor table as well as the movies he/she has been in with their roles and information on the movie. Links are provided as well for each of these movies that link to the browseM.php page.

browseM.php - This is the equivalent browse page for movies. It brings you to a search page if visited alone and similar to adding to the database if you search for a movie that shares a name you will be prompted to choose one. From there you will see the more details page where it shows the fields from the Movie table, the actors in the movie along with their role. Each one of these actors has a link to its respective browseA page. Then below that is the Comment section where it has all of the reviews. It displays the average review score so long as there is one review. There is a button which links to the review.php page for that movie to add a review if necessary.

review.php - This page is to add reviews. If visited alone, you will be prompted for all of the information along with the movie title. The title searched for the mid and if there are two movies with the same title, you will be prompted once again. The other way to get here is through the browseM.php page which automatically puts in the movie name.