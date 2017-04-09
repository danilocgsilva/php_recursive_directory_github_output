# php_recursive_directory_output

Outputs recursivelly the directory tree from a given github user name and repo name.

Usage:

1. You must have a php server with support to curl and ssl.

2. Upload the php_recursive_directory_github_output.creds.php and php_recursive_directory_github_output.php to your php server.

3. Change the value from the single variable inside php_recursive_directory_github_output.creds.php to match your github credential.

4. Access the php_recursive_directory_github_output.php in the server. Put also in the url the repo argument, which will be your repository name and the user argument, that will be your github username. Things will be like the following: http://<path-to-your-server>/php_recursive_directory_github_output.php?repo=<your-repository-name>&user=<your-user-name>

You probably will ask: "Why did you not also put the username in the php_recursive_directory_github_output.creds.php, so I needn't to provides the user argument as an argument in the url?" And I am glad to ask! The answer: the github allows you also to get directory tree without any authentication. It implies that you can make a directory listing from any user in the github and that the usage of user argument and password in the php_recursive_directory_github_output.creds.php optionals. But it limits the ammount of requests that can be done in the server by the server ip. I figures that in the most cases this script will be used to see files from the personal repository. But I want to allow list the tree from another user, and it is the first state of the script. I've made changes that may fail in use the php_recursive_directory_github_output.creds.php and username as argument optionally, but it is a todo.