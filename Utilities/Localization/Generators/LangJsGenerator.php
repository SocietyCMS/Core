<?php

namespace Modules\Core\Utilities\Localization\Generators;

use Illuminate\Filesystem\Filesystem as File;
use JShrink\Minifier;

/**
 * The LangJsGenerator class.
 *
 * @author Rubens Mariuzzo <rubens@mariuzzo.com>
 */
class LangJsGenerator
{
    /**
     * The file service.
     */
    protected $file;
    /**
     * The source path of the language files.
     */
    protected $sourcePath;

    /**
     * Construct a new LangJsGenerator instance.
     *
     * @param File $file The file service instance.
     * @param string $sourcePath The source path of the language files.
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Generate a JS lang file from all language files.
     *
     * @param string $target The target directory.
     * @param array $options Array of options.
     * @return int
     */
    public function generate($target, $options)
    {
        $messages = $this->getMessages();
        $this->prepareTarget($target);
        $template = $this->file->get(__DIR__.'/Templates/langjs_with_messages.js');
        $langjs = $this->file->get(__DIR__.'/../Lang.js/src/lang.js');
        $template = str_replace('\'{ messages }\'', json_encode($messages), $template);
        $template = str_replace('\'{ langjs }\';', $langjs, $template);
        if ($options['compress']) {
            $template = Minifier::minify($template);
        }

        return $this->file->put($target, $template);
    }

    /**
     * Add SourcePath to language files.
     *
     * @param $sourcePath
     */
    public function addSourcePath($sourcePath)
    {
        $this->sourcePath[] = $sourcePath;
    }

    /**
     * Return all language messages.
     * @return array
     * @throws \Exception
     */
    protected function getMessages()
    {
        $messages = [];
        foreach ($this->sourcePath as $path) {
            $messages = array_merge($this->getMessagesFromSourcePath($path), $messages);
        }
        return $messages;
    }

    /**
     * Return language messages for a path.
     * @param $path
     * @return array
     * @throws \Exception
     */
    protected function getMessagesFromSourcePath($path)
    {
        $messages = [];
        if (! $this->file->exists($path)) {
            throw new \Exception("${path} doesn't exists!");
        }
        foreach ($this->file->allFiles($path) as $file) {
            $pathName = $file->getRelativePathName();
            if ($this->file->extension($pathName) !== 'php') {
                continue;
            }
            $key = substr($pathName, 0, -4);
            $key = str_replace('\\', '.', $key);
            $key = str_replace('/', '.', $key);
            $messages[$key] = include "${path}/${pathName}";
        }

        return $messages;
    }

    /**
     * Prepare the target directoy.
     *
     * @param string $target The target directory.
     */
    protected function prepareTarget($target)
    {
        $dirname = dirname($target);
        if (! $this->file->exists($dirname)) {
            $this->file->makeDirectory($dirname);
        }
    }
}
