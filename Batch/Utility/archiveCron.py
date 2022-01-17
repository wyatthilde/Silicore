# * *****************************************************************************************************************************************
# * File Name: silicoreuseredit.php
# * Project: silicore_site
# * Description: 
# * Notes:
# * =========================================================================================================================================
# * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
# * =========================================================================================================================================
# * 10/19/2017|nolliff|KACE:18394 - Initial creation
# * **************************************************************************************************************************************** */

import os, shutil
from datetime import datetime,timedelta,date

dst_file = "/home/nolliff/targetfile/"
src_file="/home/nolliff/TestFiles/"

sqlFiles = os.listdir(src_file);

for file in sqlFiles:

  fileName = file
  fileName = fileName.split(".")[0]
  fileDate = fileName.split("_")[2] + fileName.split("_")[3]
  fileDate = datetime.strptime(fileDate, '%Y%m%d%H%M')
  moveDate = datetime.now() - timedelta(days=30)


  if(fileDate <= moveDate):
       shutil.move(src_file + file, dst_file)
       print(file + " successfully archived.")

