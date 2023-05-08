# AayushiIrisBlogbase
Blogbase system has a combination feature of blog and newsletter. It has newsletter layout design and meanwhile it has blog function. It has four types of users, who are admin, writer, advertisement designer and reader. Each role has its authentication. 
Admin has all authentication. Admin can approve/delete/deny user registration, approve/deny/delete blog; 
Writer can edit/post a blog;
Reader can read/save a blog;
Advertisement designer can upload an advertisement picutre;
The whole workflow of the system is as follows:
<img width="473" alt="image" src="https://user-images.githubusercontent.com/53256110/236722836-f2d12a8b-504d-42bb-b23d-d13fd5d5f19e.png">

we made 8 improvements based on the previous code.
1. We seperated roles in resgistration stage. In registration, the users can select his/her favorite role. Each role has its authentication;
2. We improved its layout;
3. We sorted all the blogs into categories, which makes it is easier to find the reader's favorite blogs;
4. We added comments function. The reader can make comments on a blog;
5. We added fuzzy search function. we used wildcard and SQL regular expression to do fuzzy search. For example, if the user wants to search for "article 03", he just needs to type a portion of the tile, such as "articl", "ar" or "03";
6. We add float window to Ad page. No one wants to click Ad page purposely. A floatwindow may lead them to advertisement page;
7. We modified CK editor. After our modification, CK editor can upload local pictures and editor local picture;
8. We modified the previous code. We deleted the redundant files and codes and make the system compatible to Mac OS.
9. 
