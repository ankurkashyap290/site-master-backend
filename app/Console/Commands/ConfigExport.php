<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Facades\Config;

class ConfigExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Laravel config files to frontend';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $export = Config::export();
        foreach ($export as $key => $value) {
            $this->comment("Exporting config: $key");
            $content = "";

            foreach (array_keys($value) as $name) {
                $constName = strtoupper($key . '_' . str_replace(' ', '_', $name));
                $content .= "export const {$constName} = '{$name}';\n";
            }

            $content .= "\n/* eslint-disable */\n";
            $content .= "const $key = ";
            $content .= json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . ";\n";
            $content .= <<<"EOF"

export function {$key}GetNameById(id) {
  return Object.keys({$key}).find(key => {$key}[key] === id);
}

export default $key;

EOF;

            file_put_contents("../frontend/src/js/config/$key.js", $content);
            $this->info("Exported config:  $key");
        }
    }
}
