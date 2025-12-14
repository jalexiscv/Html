<?php

namespace App\Libraries;

use Zest\Common\OperatingSystem;

class Files
{
    /*
     * The default value for recursive create dirs
     */

    private $recursiveDirectories = true;

    /*
     * Default value for chmod on create directory
     */
    private $defCHMOD = 0755;

    /*
     * Mine types of file
     */
    private $mineTypes = [
        'application/x-zip-compressed',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'image/gif',
        'image/jpeg',
        'image/jpeg',
        'audio/mpeg',
        'video/mp4',
        'application/pdf',
        'image/png',
        'application/zip',
        'application/et-stream',
        'image/x-icon',
        'image/icon',
        'image/svg+xml',
    ];
    /*
     * Types
     */
    private $types = [
        'image' => ['jpg', 'png', 'jpeg', 'gif', 'ico', 'svg'],
        'zip' => ['zip', 'tar', '7zip', 'rar'],
        'docs' => ['pdf', 'docs', 'docx'],
        'media' => ['mp4', 'mp3', 'wav', '3gp'],
    ];

    /*
     * resource
     */
    private $resource;
    /*
     * Mode of files
     */
    private $modes = [
        'readOnly' => 'r',
        'readWrite' => 'r+',
        'writeOnly' => 'w',
        'writeMaster' => 'w+',
        'writeAppend' => 'a',
        'readWriteAppend' => 'a+',
    ];
    private $path;
    private $url;

    /**
     * Facebook constructor.
     */
    public function __construct()
    {
        $this->path = PUBLICPATH . "storages/" . md5(APPNODE) . "/";
        $this->url = "/storages/" . md5(APPNODE) . "/";
    }

    /**
     * Define the recursive create directories.
     * @param $value recursive status true|false.
     * @return current value
     */
    public function recursiveCreateDir($value = null)
    {
        if ($value === null) {
            return $this->recursiveDirectories;
        } else {
            $this->recursiveDirectories = $value;
        }
    }

    /**
     * Define the CHMOD for created dir.
     *
     * @param $value CHMOD value default: 0755.
     *
     * @return current value
     */
    public function defaultCHMOD($value = null)
    {
        if ($value === null) {
            return $this->defCHMOD;
        } else {
            $this->defCHMOD = $value;
        }
    }

    /**
     * Add the mine type.
     *
     * @param $type correct mine type.
     *
     * @return void
     */
    public function addMineTypes($type)
    {
        array_push($this->mineTypes, $type);
    }

    /**
     * Add the extemsio.
     *
     * @param $type correct type.
     * $sub extensions
     *
     * @return void
     */
    public function addExt($type, $ext)
    {
        array_push($this->types[$type], $ext);
    }

    /**
     * Make the permission.
     * @param $source name of file or directory with path.
     * $pre valid premission
     * @return bool
     * @example: $files->permission('test.txt', 0774);
     */
    public function permission($source, $pre)
    {
        if (!is_dir($name)) {
            return (file_exists($source)) ? chmod($source, $pre) : false;
        }

        return false;
    }

    /**
     * Copy files.
     *
     * @param $source name of file or directory with path.
     * $target target directory
     * $files (array) files to be copy
     * Example: $files->copyFiles('/name', 'dir/', ['test.txt']);
     * @return void
     */
    public function copyFiles($source, $target, $files)
    {
        $this->mkDir($target);
        foreach ($files as $file => $value) {
            if (file_exists($source . $value)) {
                copy($source . $value, $target . $value);
            }
        }
    }

    /**
     * Make the dir.
     * @param $name name of dir with path.
     * @recursive $recursive recursive mode create: null|true|false.
     * @param $chmod directory permission on create: 0755
     * @return bool
     * @example $files->mkDir('name');
     */
    public function mkDir($name, $recursive = null, $chmod = null)
    {
        // test the recursive mode with default value
        $recursive = ($recursive === null) ? $this->recursiveDirectories : $recursive;
        // test the chmod with default value
        $chmod = ($chmod === null) ? $this->defCHMOD : $chmod;
        if (!is_dir($name)) {
            // this change to permit create dir in recursive mode
            return (mkdir($name, $chmod, $recursive)) ? true : false;
        }

        return false;
    }

    /**
     * Move files.
     *
     * @param $source name of file or directory with path.
     * $target target directory
     * $files (array) files to be move
     * Example: $files->moveFiles('/', 'dir/', ['test.txt']);
     * @return void
     */
    public function moveFiles($source, $target, $files)
    {
        $this->mkDir($target);
        foreach ($files as $file => $value) {
            if (file_exists($source . $value)) {
                rename($source . $value, $target . $value);
            }
        }
    }

    /**
     * Delete files.
     * Example: $files->deleteFiles(['test.txt']);
     * @param $file name of file with path.
     * @return void
     */
    public function deleteFiles($files)
    {
        foreach ($files as $file => $value) {
            if (file_exists($value)) {
                unlink($value);
            }
        }
    }

    /**
     * Copy dirs.
     *
     * @param $source directory with path.
     * $target target directory
     * $files (array) dirs to be copy
     * Example: $files->copyDirs('/', 'dir/', ['test.txt']);
     * @return void
     */
    public function copyDirs($source, $target, $dirs)
    {
        $this->mkDir($target);
        $serverOs = (new OperatingSystem())->get();
        $command = ($serverOs === 'Windows') ? 'xcopy ' : 'cp -r ';
        foreach ($dirs as $dir => $value) {
            if (is_dir($source . $value)) {
                shell_exec($command . $source . $value . ' ' . $target . $value);
            }
        }
    }

    /**
     * Move dirs.
     *
     * @param $source directory with path.
     * $target target directory
     * $dir (array) dir to be move
     * Example: $files->moveDirs('/', 'dir/', ['test.txt']);
     * @return void
     */
    public function moveDirs($source, $target, $dirs)
    {
        $this->mkDir($target);
        $command = ($serverOs === 'Windows') ? 'move ' : 'mv ';
        foreach ($dirs as $dir => $value) {
            if (is_dir($source . $value)) {
                shell_exec($command . $source . $value . ' ' . $target . $value);
            }
        }
    }

    /**
     * Delete dirs.
     * Example: $files->deleteDirs(['test.txt']);
     * @param $dir Directory with path.
     * @return void
     */
    public function deleteDirs($dir)
    {
        foreach ($files as $file => $value) {
            if (is_dir($value)) {
                rmdir($value);
            }
        }
    }

    /**
     * Upload file.
     * @param $file file to be uploaded.
     * $target target where file should be upload
     * $imgType supported => image,media,docs,zip
     * $maxSize file size to be allowed
     * @return void
     * @example $status = $files->fileUpload($_FILES['file'], '/', 'image');
     *          var_dump($status);
     */
    public function fileUpload($file, $target, $imgType, $maxSize = 7992000000)
    {
        $exactName = basename($file['name']);
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $error = $file['error'];
        $type = $file['type'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = $this->rendomFileName(30);
        $fileNewName = $newName . '.' . $ext;
        $allowerd_ext = $this->types[$imgType];
        if (in_array($type, $this->mineTypes) === false) {
            return [
                'status' => 'error',
                'code' => 'mineType',
            ];
        }
        if (in_array($ext, $allowerd_ext) === true) {
            if ($error === 0) {
                if ($fileSize <= $maxSize) {
                    $this->mkdir($target);
                    $fileRoot = $target . $fileNewName;
                    if (move_uploaded_file($fileTmp, $fileRoot)) {
                        return [
                            'status' => 'success',
                            'code' => $fileNewName,
                        ];
                    } else {
                        return [
                            'status' => 'error',
                            'code' => 'somethingwrong',
                        ];
                    }
                } else {
                    return [
                        'status' => 'error',
                        'code' => 'exceedlimit',
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'code' => $error,
                ];
            }
        } else {
            return [
                'status' => 'error',
                'code' => 'extension',
            ];
        }
    }

    /**
     * generate salts for files.
     *
     * @param string $length length of salts
     *
     * @return string
     */
    public static function rendomFileName($length)
    {
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $stringlength = count($chars); //Used Count because its array now
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $chars[rand(0, $stringlength - 1)];
        }

        return $randomString;
    }

    /**
     * Upload files.
     * @param $files (array) files to be uploaded.
     * $target target where file should be upload
     * $imgType supported => image,media,docs,zip
     * $maxSize file size to be allowed
     * @return void
     * @example $status = $files->filesUpload($_FILES['file'], '/', 'image', count($_FILES['file']['name']));
     *          var_dump($status);
     */
    public function filesUpload($files, $target, $imgType, $count, $maxSize = 7992000000)
    {
        $status = [];
        for ($i = 0; $i < $count; $i++) {
            $exactName = basename($files['name'][$i]);
            $fileTmp = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $error = $files['error'][$i];
            $type = $files['type'][$i];
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $newName = $this->rendomFileName(30);
            $fileNewName = $newName . '.' . $ext;
            $allowerd_ext = $this->types[$imgType];
            if (in_array($type, $this->mineTypes) === false) {
                $status[$i] = [
                    'status' => 'error',
                    'code' => 'mineType',
                ];
            }
            if (in_array($ext, $allowerd_ext) === true) {
                if ($error === 0) {
                    if ($fileSize <= $maxSize) {
                        $this->mkdir($target);
                        $fileRoot = $target . $fileNewName;
                        if (move_uploaded_file($fileTmp, $fileRoot)) {
                            $status[$i] = [
                                'status' => 'success',
                                'code' => $fileNewName,
                            ];
                        } else {
                            $status[$i] = [
                                'status' => 'error',
                                'code' => 'somethingwrong',
                            ];
                        }
                    } else {
                        $status[$i] = [
                            'status' => 'error',
                            'code' => 'exceedlimit',
                        ];
                    }
                } else {
                    $status[$i] = [
                        'status' => 'error',
                        'code' => $error,
                    ];
                }
            } else {
                $status[$i] = [
                    'status' => $error,
                    'code' => 'extension',
                ];
            }
        }

        return $status;
    }

    /**
     * Open the file.
     *
     * @param $name => name of file
     * $mode => mode of file
     *
     * @return resource
     */
    public function open($name, $mode)
    {
        if (!empty(trim($name))) {
            $this->resource = fopen($name, $this->modes[$mode]);
            return $this;
        }
    }

    /**
     * Read the file.
     * @param $file file that to be read
     * @return file
     * @example var_dump($files->open('test.txt', 'readOnly')->read('test.txt'));
     */
    public function read($file)
    {
        return fread($this->resource, filesize($file));
    }

    /**
     * Write on file.
     * @param $data data that you want write on file
     * @return bool
     * @example $files->open('test.txt', 'writeOnly')->write('I am test files');
     */
    public function write($data)
    {
        if (!empty($data)) {
            flock($this->resource, LOCK_EX);
            fwrite($this->resource, $data);
            flock($this->resource, LOCK_UN);
            fclose($this->resource);
        } else {
            return (false);
        }
    }

    /**
     * Delete the file.
     * @param $file file to be deleted
     * @return bool
     * @example: $files->delete('test.txt');
     */
    public function delete($file)
    {
        //delete_files($file);
        return (file_exists($file)) ? unlink($file) : false;
    }

    /**
     * Trasfiere un archivo remoto al localhost
     * @param type $directory
     * @param type $file
     * @param type $url
     * @return type
     */
    public function transfer($directory, $file, $url)
    {
        if ($this->exists($url)) {
            $source = file_get_contents($url);
            $path = $this->path . $directory;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $tfile = "{$path}/{$file}";
            $cfile = fopen($tfile, "w+b");
            fclose($cfile);
            file_put_contents($tfile, $source);
            $result["uri"] = "{$path}{$file}";
            $result["url"] = $this->url . "{$directory}{$file}";
//                $result["type"] = $utype;
//                $result["size"] = $usize;
            return ($result);
        } else {
            echo("<br>El Archivo no existe: " . $url);
            return (false);
        }
    }

    /**
     * Verifica la existencia de un archivo mediante el acceso a su URL.
     * @param type $url
     * @return boolean
     */
    public function exists($url = NULL)
    {
        if (empty($url)) {
            return false;
        }
        $options['http'] = array(
            'method' => "HEAD",
            'ignore_errors' => 1,
            'max_redirects' => 0
        );
        $body = file_get_contents($url, false, stream_context_create($options));
        // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php
        if (isset($http_response_header)) {
            //print_r($http_response_header);
            sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode);
            //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
            $accepted_response = array(200, 301, 302);
            if (in_array($httpcode, $accepted_response)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>