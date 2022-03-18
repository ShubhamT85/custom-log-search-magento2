<?php
namespace Task\SearchLog\Block\Adminhtml\Display;

class Log extends \Magento\Backend\Block\Template
{
    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var File
     */
    protected $driverFile;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\FileSystem\DirectoryList $directoryList,
        \Magento\Framework\FileSystem\Driver\File $driverFile,
        array $data = []
    ) {
        $this->directoryList = $directoryList;
        $this->driverFile = $driverFile;
        parent::__construct($context, $data);
    }

    public function allLogs()
    {
        $files = array();
        $folder = '/log/';
        $path = $this->directoryList->getPath('var') . $folder;
        $collection = $this->driverFile->readDirectory($path);

        // read log directory
        foreach ($collection as $filename) {
            $logName = substr($filename, stripos($filename, 'log/'));
            $files[] = substr($logName, 4);
        }
        return $files;
    }

    public function checkData()
    {
        $logFileName = $this->getRequest()->getParam('log_name');
        $collection = [];
        $check_files = [];
        $final_collection = [];
        $flag = false;
        try {
            $folder = '/log/';
            $path = $this->directoryList->getPath('var') . $folder;
            $collection = $this->driverFile->readDirectory($path);

            // read log directory
            foreach ($collection as $filename) {
                if (stripos($filename, $logFileName, 20)) {
                    $check_files[] = $filename;
                }
            }

            // check files containing the mentioned name along with search keyword and length required
            if (!empty($check_files)) {
                foreach ($check_files as $file) {
                    if ($this->driverFile->isExists($file)) {
                        $content = $this->driverFile->fileGetContents($file);
                        $searchKeyword = $this->getRequest()->getParam('log_keyword');
                        $position = stripos($content, $searchKeyword);
                        if ($position !== false) {
                            $lengthOfLog = $this->getRequest()->getParam('log_length');
                            $endOfString = $lengthOfLog;
                            // @codingStandardsIgnoreStart
                            $requiredContent = file_get_contents($file, true, null, $position, $endOfString);
                            // @codingStandardsIgnoreEnd
                            $logName = substr($file, stripos($file, $logFileName));
                            $final_collection[$logName] = $requiredContent;
                            $flag = true;
                        } else {
                            return "No match found";
                        }
                    } else {
                        return "No files found";
                    }
                }
            }

            if ($flag == true) {
                return $final_collection;
            } else {
                return "No files found";
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
