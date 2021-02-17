<?php
declare(strict_types = 1);
/*****************************************************************************
 * Enthusiast: Listing Collective Management System
 * Copyright (c) by Ekaterina http://scripts.robotess.net
 *
 * Enthusiast is a tool for (fan)listing collective owners to easily
 * maintain their listing collectives and listings under that collective.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * For more information please view the readme.txt file.
 ******************************************************************************/

namespace RobotessNet\JoinFl;

use RobotessNet;
use function explode;
use function md5;
use function ob_get_clean;
use function ob_start;
use function preg_replace_callback;
use function str_replace;
use function strtr;
use function uniqid;

final class Form
{
    private string $template;

    private function __construct(string $template)
    {
        $this->template = $template;
    }

    public static function create(string $template): self
    {
        return new self($template);
    }

    public function output(
        array $info,
        string $errorstyle,
        array $countriesValues,
        array $fields,
        array $values,
        array $messages = [],
        ?string $email = null,
        ?string $name = null,
        ?string $url = null,
        ?string $country = null,
        ?string $comments = null,
        ?int $countryId = null
    ): string {

        $output = $this->template;

        $cutup = explode('@', $info['email']);
        if ($cutup !== false) {
            $email_js = '<script type="text/javascript">' . "\r\n<!--\r\n" .
                "jsemail = ( '$cutup[0]' + '@' + '$cutup[1]' ); \r\n" .
                "document.write( '<a href=\"mailto:' + jsemail + '\">email me</' + " .
                "'a>' );\r\n" . ' -->' . "\r\n" . '</script>';
        } else {
            $email_js = $info['email'];
        }
        $output = str_replace('$$email_js$$', $email_js ?? '', $output);

        $output = str_replace('$$messages_form$$', $messages['form'] ? "<p$errorstyle>{$messages['form']}</p>" : '',
            $output);

        $output = preg_replace_callback(
            '|\$\$messages\[([a-z]+)]\$\$|',
            static function ($matches) use ($messages, $errorstyle) {
                $name = $matches[1];

                return $messages[$name] ? "<p$errorstyle>{$messages[$name]}</p>" : '';
            },
            $output
        );

        $output = preg_replace_callback(
            '|\$\$info\[([a-z]+)]\$\$|',
            static function ($matches) use ($info) {
                $name = $matches[1];

                return $info[$name] ?? '';
            },
            $output
        );

        $output = preg_replace_callback('|\$\$credits\$\$|', static function () {
            ob_start(); ?>
            <p style="text-align: center;" class="show_join_credits">
                <?php include ENTH_PATH . 'show_credits.php' ?>
            </p>
            <?php
            return ob_get_clean();
        }, $output);

        if ($info['country'] == 1) {
            $output = strtr($output, ['$$country_block[start]$$' => '', '$$country_block[end]$$' => '']);

            $output = preg_replace_callback('|\$\$countries_options\$\$|',
                static function () use ($countriesValues, $country, $countryId) {
                    ob_start();
                    foreach ($countriesValues as $key => $countryVal) {
                        $selected = '';
                        if ($country !== '' && $countryId === $key) {
                            $selected = ' selected="selected"';
                        }
                        echo '<option value="' . $key . '"' . $selected . '>' . $countryVal . '</option>';
                    }

                    return ob_get_clean();
                }, $output);
        } else {
            $output = preg_replace('|\$\$country_block\[start]\$\$.*\$\$country_block\[end]\$\$|s', '', $output);
        }

        $output = preg_replace_callback('|\$\$extra_fields\$\$|', static function () use ($fields, $values) {
            ob_start();
            if (count($fields) === 0) {
                return '';
            }

            if (file_exists('addform.inc.php')) {
                require('addform.inc.php');
            } else {
                foreach ($fields as $field) {
                    ?>
                    <p class="show_join_<?= $field ?>">
         <span style="display: block;" class="show_join_<?= $field ?>_label">
         <?= ucwords(str_replace('_', ' ', $field)) ?>:</span>
                        <input type="text" name="enth_<?= $field ?>" value="<?= $values[$field]
                        ?>" class="show_join_<?= $field ?>_field"/>
                    </p>
                    <?php
                }
            }

            return ob_get_clean();
        }, $output);

        // extra spam checking variable
        $rand = md5(uniqid('', true));
        $nonce = '<input type="hidden" name="enth_join" value="yes"/>
<input type="hidden" name="enth_nonce" value="' . $rand . ':' . strtotime(date('r')) . ':' . md5($rand) . substr($rand,
                2, 3) . '"/>
        <!-- Enthusiast ' . RobotessNet\App::getVersion() . ' Join Form -->';

        $output = str_replace('$$nonce$$', $nonce ?? '', $output);
        $output = str_replace('$$name$$', $name ?? '', $output);
        $output = str_replace('$$email$$', $email ?? '', $output);
        $output = str_replace('$$url$$', $url ?? '', $output);
        $output = str_replace('$$comments$$', $comments ?? '', $output);

        return $output;
    }
}
