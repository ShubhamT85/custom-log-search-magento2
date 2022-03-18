# Magento 2(Search Logs via keyword)
1. This module helps in searching desired data from the selected log file.
2. Admin menu named **SEARCH LOGS** is created for searching logs.
## Basic Flow of the module
- Firstly, after cloning the git and extracting the folder wrap it inside folder **SearchLog** and again wrap this folder in **Task** so inshort, create your directory as magento-root-directory/app/code/Task/SearchLog/cloned_directory.
- After that open the magento root directory in terminal and hit the following commands,
  - `sudo php bin/magento module:enable Task_SearchLog`
  - `sudo php bin/magento setup:upgrade`
  - `sudo php bin/magento setup:di:compile`
  - `sudo php bin/magento setup:static-content:deploy -f`
  - `sudo php bin/magento indexer:reindex` (optional)
  - `sudo php bin/magento cache:flush`
  - `sudo chmod 777 -R var/ pub/ generated/`
- Now, open your web browser and type in the following link to open magento admin (assuming for localhost or else type in https://your-magento-url/admin) **localhost/magento-root-directory/admin** you will see an admin menu named **SEARCH LOGS**.
- Reference Image : https://ibb.co/wyHXSzM
- On clicking the admin menu you will be redirected to a page with a submit button , select the desired log file from dropdown and enter the desired keyword through which you want the data from that log file along with the data length required.
- Click on submit and then you will get one of the two messages:
  1. *Required data will be visible in a table format with file name in first and content in the second column.*
  2. *No files found* - either you have provided a fake or mistaken keyword else the searched keyword has no found results i.e. such keyword in the file doesn't exist.

### Happy Coding :)
