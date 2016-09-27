using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using OpenQA.Selenium;
using OpenQA.Selenium.Firefox;
using OpenQA.Selenium.Support.UI;

namespace Selenium
{
    /// <summary>
    /// 
    /// This class uses Selenium to test the TA Application website.  The tests below are run and text is
    /// printed to the console showing whether or not each test passed and why.  The tests may be run
    /// separately, but only as specified (2-3 must be run together, 4-6 must be run together)
    /// 
    /// Author: Kyle Pierson
    /// Date: 4/3/2015
    /// Version: 1.0
    /// Project: TA Application Website Tester Using Selenium
    /// 
    /// </summary>
    class TATester
    {
        static void Main(string[] args)
        {
            Console.WriteLine("TA Application Website Tester Using Selenium");
            IWebDriver driver = null;

            try
            {
                driver = new FirefoxDriver();
                driver.Navigate().GoToUrl("http://uofu-cs4540-57.cloudapp.net");

                //
                // Setup the driver to wait for up to 10 seconds before giving up on finding
                // an element.  This is important when pages load slowly
                //
                driver.Manage().Timeouts().ImplicitlyWait(new TimeSpan(0, 0, 10));

                // Navigate to the register page
                driver.FindElement(By.LinkText("My Projects")).Click();
                driver.FindElement(By.LinkText("Phase 7")).Click();

                // Test registration
                test_one(driver);
                // Test the applicant (must be performed together)
                test_two(driver);
                test_three(driver);
                // Test the admin (must be performed together)
                test_four(driver);
                test_five(driver);
                test_six(driver);
                // Test the instructor
                test_seven(driver);

                Console.WriteLine("Tests completed");
                driver.Close();
                Console.Read();
            }
            catch(Exception e)
            {
                Console.WriteLine(e.Message);
                try
                {
                    driver.Close();
                }
                catch (Exception exc)
                {
                }
            }
        }

        /// <summary>
        /// Test setting up an account (the user will already exist)
        /// </summary>
        /// <param name="driver"></param>
        public static void test_one(IWebDriver driver)
        {
            bool test = true;
            driver.FindElement(By.LinkText("Set Up An Account")).Click();

            IWebElement submit = driver.FindElement(By.Id("register"));

            // Send in some register information
            driver.FindElement(By.Name("first")).SendKeys("aaa");
            driver.FindElement(By.Name("last")).SendKeys("bbb");
            driver.FindElement(By.Name("email")).SendKeys("ccc@ccc.com");
            IWebElement pass_one = driver.FindElement(By.Name("pass"));
            IWebElement pass_two = driver.FindElement(By.Name("pass2"));

            // Send in different passwords
            pass_one.SendKeys("ddd");
            pass_two.SendKeys("eee");

            submit.Click();

            IWebElement error = driver.FindElement(By.Name("passerror1"));

            // Should get an error of passwords don't match
            String message = error.Text;
            String expected = "Passwords don't match";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("1 Registration test failed: page showed " + message + " instead of " + expected);
            }

            // Pass in matching passwords
            pass_one.Clear();
            pass_two.Clear();
            pass_one.SendKeys("ddd");
            pass_two.SendKeys("ddd");

            submit.Click();

            // Should get this error
            message = error.Text;
            expected = "Password must contain at least six characters";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("1 Registration test failed: page showed " + message + " instead of " + expected);
            }

            // Pass in passwords that match the email
            pass_one.Clear();
            pass_two.Clear();
            pass_one.SendKeys("ccc@ccc.com");
            pass_two.SendKeys("ccc@ccc.com");

            submit.Click();

            // Should get this error
            message = error.Text;
            expected = "Password must be different from name or email";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("1 Registration test failed: page showed " + message + " instead of " + expected);
            }

            pass_one.Clear();
            pass_two.Clear();
            pass_one.SendKeys("dddeee");
            pass_two.SendKeys("dddeee");

            submit.Click();

            // Good passwords, but the login is already in use (this test was already performed)
            message = driver.FindElement(By.Name("emailerror")).Text;
            expected = "That login name is already in use";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("1 Registration test failed: page showed " + message + " instead of " + expected);
            }
            else if (test)
            {
                Console.WriteLine("1 Registration test passed");
            }
        }

        /// <summary>
        /// Tests logging in as an applicant
        /// </summary>
        /// <param name="driver"></param>
        public static void test_two(IWebDriver driver)
        {
            bool test = true;
            driver.FindElement(By.LinkText("Log In")).Click();

            // Wrong password
            driver.FindElement(By.Name("log_email")).SendKeys("ccc@ccc.com");
            driver.FindElement(By.Name("log_pass")).SendKeys("ddddddd");

            driver.FindElement(By.Id("submit")).Click();

            String message = driver.FindElement(By.Id("message")).Text;
            String expected = "Incorrect username or password";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("2 Login test failed: page showed " + message + " instead of " + expected);
            }

            // Correct password
            driver.FindElement(By.Name("log_email")).SendKeys("ccc@ccc.com");
            driver.FindElement(By.Name("log_pass")).SendKeys("dddeee");

            driver.FindElement(By.Id("submit")).Click();

            message = driver.FindElement(By.Id("app_header")).Text;
            expected = "Hello Applicant!";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("2 Login test failed: page showed " + message + " instead of " + expected);
            }
            else if (test)
            {
                Console.WriteLine("2 Login test passed");
            }
        }

        /// <summary>
        /// Tests submitting an application and reviewing that application
        /// </summary>
        /// <param name="driver"></param>
        public static void test_three(IWebDriver driver)
        {
            // Type the major and an invalid GPA
            bool test = true;
            driver.FindElement(By.LinkText("Apply Here")).Click();

            driver.FindElement(By.Id("Major")).SendKeys("Computer Science");

            IWebElement gpa = driver.FindElement(By.Id("GPA"));
            gpa.SendKeys("-50");
            driver.FindElement(By.Id("AcademicJun")).Click();

            // Pick a course taken
            IWebElement course = driver.FindElement(By.Name("loop[]"));
            SelectElement selector = new SelectElement(course);
            selector.SelectByIndex(12);

            // Try to add another class (should get a javascript error)
            driver.FindElement(By.Id("Add")).Click();
            IWebElement error = driver.FindElement(By.Id("message"));

            String message = error.Text;
            String expected = "To add another class, you must fill out all fields";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            // Add the necessary information and add the class
            IWebElement grade = driver.FindElement(By.Name("grade"));
            selector = new SelectElement(grade);
            selector.SelectByIndex(2);

            IWebElement term = driver.FindElement(By.Name("term"));
            selector = new SelectElement(term);
            selector.SelectByIndex(2);

            IWebElement year = driver.FindElement(By.Name("year"));
            selector = new SelectElement(year);
            selector.SelectByIndex(5);
            
            driver.FindElement(By.Id("Add")).Click();
            driver.FindElement(By.Id("Add_app")).Click();
            error = driver.FindElement(By.Id("app_message"));

            // Try to apply for a class without selecting one!
            message = error.Text;
            expected = "Please select a class to apply for";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            IWebElement app = driver.FindElement(By.Name("app_loop[]"));
            selector = new SelectElement(app);
            selector.SelectByIndex(20);

            // Submit the class and essay
            driver.FindElement(By.Name("essay")).SendKeys("This is my essay");
            driver.FindElement(By.Id("Add_app")).Click();
            driver.FindElement(By.Name("SubmitButton")).Click();

            // Should get a GPA error from when we entered in an invalid GPA
            message = error.Text;
            expected = "Please enter a valid GPA between 0 and 4";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            // Fix the GPA
            gpa.Clear();
            gpa.SendKeys("3.8");
            driver.FindElement(By.Name("SubmitButton")).Click();

            // Application submitted!
            message = driver.FindElement(By.Id("app_header")).Text;
            expected = "Your Application Was Submitted!";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            // View applications
            driver.FindElement(By.LinkText("View Your Applications")).Click();
            driver.FindElement(By.Name("SubmitButton")).Click();

            message = driver.FindElement(By.Id("email")).Text;
            expected = "ccc@ccc.com";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            // Make sure the class taken has the right teacher (pulled from database)
            message = driver.FindElement(By.Id("teacher")).Text;
            expected = "P. A. JENSEN";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            // Check all of the class application information
            message = driver.FindElement(By.Id("element1")).Text;
            expected = "CS";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            message = driver.FindElement(By.Id("element2")).Text;
            expected = "1400";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            message = driver.FindElement(By.Id("element3")).Text;
            expected = "This is my essay";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            message = driver.FindElement(By.Id("element4")).Text;
            expected = "Applied";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("3 Application test failed: page showed " + message + " instead of " + expected);
            }

            else if (test)
            {
                Console.WriteLine("3 Application test passed");
            }
            driver.FindElement(By.LinkText("Logged in as aaa (Log Out)")).Click();
        }

        /// <summary>
        /// Log in as an Admin, test the retrieval of information from the database and catalog
        /// Also test the AJAX of assigning TAs to courses
        /// </summary>
        /// <param name="driver"></param>
        public static void test_four(IWebDriver driver)
        {
            bool test = true;
            driver.FindElement(By.LinkText("Log In")).Click();

            // Log in
            driver.FindElement(By.Name("log_email")).SendKeys("theboss");
            driver.FindElement(By.Name("log_pass")).SendKeys("theboss");

            driver.FindElement(By.Id("submit")).Click();
            driver.FindElement(By.LinkText("View Classes")).Click();

            IWebElement course = driver.FindElement(By.Name("year"));
            SelectElement selector = new SelectElement(course);
            selector.SelectByIndex(1);

            // Get the enrolled for a specific course
            driver.FindElement(By.Name("submit")).Click();
            System.Collections.ObjectModel.ReadOnlyCollection<IWebElement> enrolled = driver.FindElements(By.XPath("//td[@class='c_enroll']"));
            String initial = enrolled.ElementAt(2).Text;

            // Should be 89
            String message = enrolled.ElementAt(2).Text;
            String expected = "89";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("4 Admin classes test failed: page showed " + message + " instead of " + expected);
            }

            driver.FindElement(By.Name("reset")).Click();
            System.Collections.ObjectModel.ReadOnlyCollection<IWebElement> reset = driver.FindElements(By.XPath("//td[@class='c_enroll']"));
            
            // Reset enroll should be 0
            message = reset.ElementAt(2).Text;
            expected = "0";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("4 Admin classes test failed: page showed " + message + " instead of " + expected);
            }

            // Re-scrape enroll, should be 89 again
            driver.FindElement(By.Name("fetch")).Click();
            System.Collections.ObjectModel.ReadOnlyCollection<IWebElement> scraped_enrolled = driver.FindElements(By.XPath("//td[@class='c_enroll']"));
            message = scraped_enrolled.ElementAt(2).Text;
            expected = initial;
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("4 Admin classes test failed: page showed " + message + " instead of " + expected);
            }

            // Pick CS 1000 as an assigned class
            course = driver.FindElement(By.Id("assign_class"));
            selector = new SelectElement(course);
            selector.SelectByIndex(3);

            // Make sure the person (Kyle) is unassigned
            message = driver.FindElement(By.XPath("//tr[@id='0']")).FindElement(By.ClassName("status")).Text;
            expected = "Unassigned";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("4 Admin classes test failed: page showed " + message + " instead of " + expected);
            }

            // Assign Kyle
            course = driver.FindElement(By.XPath("//tr[@id='0']")).FindElement(By.Name("update_ta"));
            selector = new SelectElement(course);
            selector.SelectByIndex(0);

            // Make sure it displays as assigned
            message = driver.FindElement(By.XPath("//tr[@id='0']")).FindElement(By.ClassName("status")).Text;
            expected = "Assigned";
            if (!message.Equals(expected))
            {
                test = false;
                Console.WriteLine("4 Admin classes test failed: page showed " + message + " instead of " + expected);
            }

            // On the view applicants page, Kyle should now be assigned to this course
            driver.FindElement(By.LinkText("View Applicants")).Click();

            IWebElement table = driver.FindElements(By.TagName("table")).ElementAt(0);
            IWebElement row = table.FindElements(By.TagName("tr")).ElementAt(3);
            IWebElement assigned = row.FindElements(By.TagName("td")).ElementAt(3);

            message = assigned.Text;
            expected = "CS 1000";

            // From our previous test, Kyle should be applied to CS 1000 but not assigned
            if (!message.Contains(expected))
            {
                test = false;
                Console.WriteLine("4 Admin classes test failed: page not showing that Kyle assigned to CS 1000");
            }
            else if(test)
            {
                Console.WriteLine("4 Admin classes test passed");
            }

            // Navigate back to View Classes
            driver.FindElement(By.LinkText("View Classes")).Click();

            course = driver.FindElement(By.Name("year"));
            selector = new SelectElement(course);
            selector.SelectByIndex(1);
            driver.FindElement(By.Name("submit")).Click();

            // Pick CS 1000 as an assigned class
            course = driver.FindElement(By.Id("assign_class"));
            selector = new SelectElement(course);
            selector.SelectByIndex(3);

            // Unassign him again for future tests
            course = driver.FindElement(By.XPath("//tr[@id='0']")).FindElement(By.Name("update_ta"));
            selector = new SelectElement(course);
            selector.SelectByIndex(2);
        }

        /// <summary>
        /// Checks the View Applicants page to make sure it is consistent with other pages
        /// </summary>
        /// <param name="driver"></param>
        public static void test_five(IWebDriver driver)
        {
            bool test = true;
            driver.FindElement(By.LinkText("View Applicants")).Click();

            // Shows how to navigate to a specific data value with no IDs or classes
            IWebElement table = driver.FindElements(By.TagName("table")).ElementAt(0);
            IWebElement row = table.FindElements(By.TagName("tr")).ElementAt(3);
            IWebElement applied = row.FindElements(By.TagName("td")).ElementAt(1);
            IWebElement assigned = row.FindElements(By.TagName("td")).ElementAt(3);

            String message = applied.Text;
            String expected = "CS 1000";

            // From our previous test, Kyle should be applied to CS 1000 but not assigned
            if (!message.Contains(expected))
            {
                test = false;
                Console.WriteLine("5 Admin applicant test failed: page not showing that Kyle applied for CS 1000");
            }
            message = assigned.Text;
            if (message.Contains(expected))
            {
                test = false;
                Console.WriteLine("5 Admin applicant test failed: page showing that Kyle is assigned to CS 1000 after we had changed that previously");
            }

            // We should also now have an application for aaa (the newly registered test person)
            message = driver.FindElement(By.Id("aaa bbbcourses")).Text;
            expected = "CS 1400,";
            if (!message.Contains(expected))
            {
                test = false;
                Console.WriteLine("5 Admin applicant test failed: page showed " + message + " instead of " + expected);
            }
            else if(test)
            {
                Console.WriteLine("5 Admin applicant test passed");
            }
        }

        /// <summary>
        /// Test the comment button in the TA Evaluations page
        /// </summary>
        /// <param name="driver"></param>
        public static void test_six(IWebDriver driver)
        {
            bool test = true;
            driver.FindElement(By.LinkText("View TA Evaluations")).Click();
            // Go to the button on the first row
            driver.FindElement(By.XPath("//button[@id='39']")).Click();

            // Go to the div inside a td that has the button (should now show the comment)
            String message = driver.FindElement(By.XPath("//div[@id='39']")).Text;
            String expected = "This is a comment";
            if (!message.Contains(expected))
            {
                test = false;
                Console.WriteLine("6 Admin evaluation test failed: page showed " + message + " instead of " + expected);
            }

            // Click the button again
            driver.FindElement(By.XPath("//button[@id='39']")).Click();
            message = driver.FindElement(By.XPath("//div[@id='39']")).Text;

            // There should now be no comment (if it still contains the comment, something is wrong)
            if (message.Contains(expected))
            {
                test = false;
                Console.WriteLine("6 Admin evaluation test failed: page showed " + message + " instead of nothing");
            }
            else if(test)
            {
                Console.WriteLine("6 Admin evaluation test passed");
            }

            driver.FindElement(By.LinkText("Logged in as theboss (Log Out)")).Click();
        }

        /// <summary>
        /// Quick test of the Instructor class TAs
        /// </summary>
        /// <param name="driver"></param>
        public static void test_seven(IWebDriver driver)
        {
            driver.FindElement(By.LinkText("Log In")).Click();

            driver.FindElement(By.Name("log_email")).SendKeys("H. J. DE ST GERMAIN");
            driver.FindElement(By.Name("log_pass")).SendKeys("temp");

            driver.FindElement(By.Id("submit")).Click();
            driver.FindElement(By.LinkText("View Possible TAs For Your Classes")).Click();

            // Shows how to navigate to a value without IDs or classes
            IWebElement table = driver.FindElements(By.TagName("table")).ElementAt(0);
            IWebElement row = table.FindElements(By.TagName("tr")).ElementAt(1);
            IWebElement data = row.FindElements(By.TagName("td")).ElementAt(0);
            
            // This value should be Harry Potter (the first registered user)
            String message = data.Text;
            String expected = "Harry Potter";

            if (!message.Contains(expected))
            {
                Console.WriteLine("7 Instructor test failed: page showed " + message + " instead of " + expected);
            }
            else
            {
                Console.WriteLine("7 Instructor test passed");
            }

            driver.FindElement(By.LinkText("Logged in as H. J. (Log Out)")).Click();
        }
    }
}
