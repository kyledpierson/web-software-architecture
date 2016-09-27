------------------------------------------------------------------------------------------------------------------

AUTHOR: Kyle Pierson
DATE: 4/2/2015
VERSION: 1.0
PROJECT: TA Application Tester Using Selenium

------------------------------------------------------------------------------------------------------------------

This tester uses the Selenium Web Driver to simulate a Firefox browser, navigate to my website at
uofu-cs4540-57.cloudapp.net and perform coded, automated UI testing against multiple pages in the website.
Various values from the website are scraped to ensure their correctness, and various inputs are given to the
webiste to ensure that the site reacts in the expected way.

The first test walks through the registration of a new user.  The user enters in a first and last name and
email, and then tries to enter in two conflicting passwords.  The error is validated for correctness, and the
user tries to enter in the same password for both boxes, but with a length of three.  This is also disallowed,
and the proper error message should be thrown.  Finally, the user enters in a password that is the same as
the email.  An error message is thrown, and the user ultimately complies and enters in a valid password.  It
turns out that this user has already registered, so the next page should show accordingly.

The second test makes sure that the login page correctly validates information.  The user tries to put in 
an incorrect password, and the message is validated.  The user then logs in with the correct username and
password.

The third test walks through the user applying for a course.  The user fills out the major and an invalid GPA
of -50.  The user then selects a class it has taken, but when trying to add the class is denied because it
didn't provide the other information.  On providing the information, the user tries to add an application,
but is denied because it didn't choose a class to apply for.  The user choose a class an writes an essay.
When trying to submit, the user gets an error concerning the invalid GPA.  On clearing and correcting the
GPA, the user has now submitted an application.  It views the application and checks to make sure that the
class taken teacher is correct, and that the class application information is correct.

The fourth test logs the user in as an admin and views class information.  It pulls the classes from Fall of
2009 from the database.  The third entry should have an enrollment of 89, and this is checked.  The user can
then reset the enrollments to zero, pull from the database, and ensure that the value is not 89, but 0.  Now
the information is re-scraped, and the value should again be 89.  The user tries to select CS 1000 from the
list of classes to view TA information.  It checks to make sure the first applicant is unassigned, and then
assigns him.  The value of 'status' in the table should be updated to assigned, and this is checked.  The
user then navigates to the Applicants page, and ensures that this applicant now shows up as Assigned for
CS 1000.  The user then navigates back to the previous page and unassigns the applicant so that future tests
won't fail.

The fifth test views the applicants from the Admin page.  It checks to make sure that Kyle (for whom we had
previousy altered the information) is applied (unassigned) and not assigned.  It then makes sure that the test
user aaa is added to the list of applicants, and that he has applied for CS 1400 as we did in test 3.

The sixth test views the evaluations, and ensures that when clicking the 'show comments' button, a comment
is shown.  It also ensures that when reclicking the button, the comment is again hid.

The seventh test logs the user in as an instructor.  It navigates to the page where the instructor can
view possible TA's for his courses.  This test specifically shows how to navigate through a table when
there are no ID's, classes, etc.  It ensures that Harry Potter (who was the first registered user) is the
first entry in possible TA's.

------------------------------------------------------------------------------------------------------------------

Throughout my code, I did a great job of using all of the possible functions in finding elements on the page,
including:

XPath
LinkText
ClassName
Name
Id
TagName

I also showed how to use IWebElement functions such as click, clear, text, etc.  There were also places where
I used the FindElements to get a collection, and retrieved values from that.  I believe I have shown that I
can effectively use Selenium to nagivate, scrape, and test a webpage, which was the purpose of this assignment.

------------------------------------------------------------------------------------------------------------------

I could have easily expanded these tests to ensure consistent data all across my website.  For example, after
changing one piece of information on one page that is saved to the database (such as an applicants status) I
could have navigated back to that applicant, logged in, and ensured that the applicant's status had been
updated.  I could have also checked for every value on every row in the Admin's View Courses page to ensure
that all classes had been added to this page from the catalog.  I chose merely to test selective data on pages
rather than the entire text of the page, but I feel that would be unneccessary.  I simply wanted to show that I
could do it.

------------------------------------------------------------------------------------------------------------------

END