<?php
// This file is part of agpu - http://agpu.org/
//
// agpu is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// agpu is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.

namespace core_files\redactor\services;

/**
 * Tests for the EXIF remover service.
 *
 * If you wish to use these unit tests all you need to do is add the following definition to
 * your config.php file:
 *
 * define('TEST_PATH_TO_EXIFTOOL', '/usr/bin/exiftool');
 *
 * @package   core_files
 * @copyright Meirza <meirza.arson@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @covers \core_files\redactor\services\exifremover_service
 */
final class exifremover_service_test extends \advanced_testcase {
    /**
     * Tests the `exifremover_service` functionality using PHP GD.
     *
     * This test verifies the ability of the `exifremover_service` to remove all EXIF
     * tags from an image file when using PHP GD. It ensures that all tags, including
     * GPSLatitude, GPSLongitude, and Orientation, are removed from the EXIF data.
     *
     * @return void
     */
    public function test_exifremover_service_with_gd(): void {
        $this->resetAfterTest(true);

        // Ensure that the exif remover tool path is not set.
        set_config('exifremovertoolpath', null, 'core_files');

        $sourcepath = self::get_fixture_path('core_files', 'redactor/dummy.jpg');

        // Get the EXIF data from the original file.
        $currentexif = $this->get_exif_data_from_file($sourcepath);
        $this->assertStringContainsString('GPSLatitude', $currentexif);
        $this->assertStringContainsString('GPSLongitude', $currentexif);
        $this->assertStringContainsString('Orientation', $currentexif);

        // Redact the file.
        $service = new exifremover_service();
        $newfile = $service->redact_file_by_path('image/jpeg', $sourcepath);

        // Get the EXIF data from the new file.
        $newexif = $this->get_exif_data_from_file($newfile);

        // Removing the "all" tags will result in removing all existing tags.
        $this->assertStringNotContainsString('GPSLatitude', $newexif);
        $this->assertStringNotContainsString('GPSLongitude', $newexif);
        $this->assertStringNotContainsString('Orientation', $newexif);
    }

    /**
     * Tests the `exifremover_service` functionality using ExifTool.
     *
     * This test verifies the ability of the `exifremover_service` to remove specific
     * EXIF tags from an image file when configured to use ExifTool. The test includes
     * scenarios for removing all EXIF tags and for removing only GPS tags.
     */
    public function test_exifremover_service_with_exiftool(): void {
        $this->require_exiftool();
        $this->resetAfterTest(true);

        $sourcepath = self::get_fixture_path('core_files', 'redactor/dummy.jpg');
        set_config('file_redactor_exifremovertoolpath', TEST_PATH_TO_EXIFTOOL);

        // Remove All tags.
        set_config('file_redactor_exifremoverremovetags', 'all');
        $service = new exifremover_service();
        $newfile = $service->redact_file_by_path('image/jpeg', $sourcepath);

        // Get the EXIF data from the new file.
        $newexif = $this->get_exif_data_from_file($newfile);

        // Removing the "all" tags will result in removing all existing tags.
        $this->assertStringNotContainsString('GPSLatitude', $newexif);
        $this->assertStringNotContainsString('GPSLongitude', $newexif);
        $this->assertStringNotContainsString('Aperture', $newexif);

        // Orientation is a preserve tag. Ensure it always exists.
        $this->assertStringContainsString('Orientation', $newexif);

        // Remove the GPS tag only.
        set_config('file_redactor_exifremoverremovetags', 'gps');

        $service = new exifremover_service();
        $newfile = $service->redact_file_by_path('image/jpeg', $sourcepath);

        // Get the EXIF data from the new file.
        $newexif = $this->get_exif_data_from_file($newfile);

        // The GPS tag only removal will remove the tag containing "GPS" keyword.
        $this->assertStringNotContainsString('GPSLatitude', $newexif);
        $this->assertStringNotContainsString('GPSLongitude', $newexif);

        // And keep the other tags remaining.
        $this->assertStringContainsString('Aperture', $newexif);

        // Orientation is a preserve tag. Ensure it always exists.
        $this->assertStringContainsString('Orientation', $newexif);
    }

    /**
     * Tests the `is_mimetype_supported` method.
     *
     * This test initializes the `exifremover_service` and verifies if the given
     * MIME types are supported for EXIF removal using both PHP GD and ExifTool.
     */
    public function test_exifremover_service_is_mimetype_supported_generic(): void {
        $service = new exifremover_service();

        // Ensure that an unsupported mimetype is not accepted.
        $this->assertFalse($service->is_mimetype_supported('application/binary'));

        // An unsupported mimetype will just return null.
        $sourcepath = self::get_fixture_path('core_files', 'redactor/dummy.jpg');
        $this->assertNull($service->redact_file_by_path('application/binary', $sourcepath));
        $this->assertNull($service->redact_file_by_content('application/binary', $sourcepath));
    }

    /**
     * Tests the `is_mimetype_supported` method.
     *
     * This test initializes the `exifremover_service` and verifies if the given
     * MIME types are supported for EXIF removal using both PHP GD and ExifTool.
     */
    public function test_exifremover_service_is_mimetype_supported_gd(): void {
        $this->resetAfterTest(true);

        // Ensure that the exif remover tool path is not set.
        set_config('file_redactor_exifremovertoolpath', null);

        $service = new exifremover_service();

        // The default MIME type is supported.
        $this->assertTrue($service->is_mimetype_supported(exifremover_service::DEFAULT_MIMETYPE));

        // Other than the default, the function will returns false.
        $this->assertFalse($service->is_mimetype_supported('image/tiff'));
    }

    /**
     * Tests the `is_mimetype_supported` method.
     *
     * This test initializes the `exifremover_service` and verifies if the given
     * MIME types are supported for EXIF removal using both PHP GD and ExifTool.
     */
    public function test_exifremover_service_is_mimetype_supported_exiftool(): void {
        $this->require_exiftool();
        $this->resetAfterTest(true);

        set_config('file_redactor_exifremovertoolpath', TEST_PATH_TO_EXIFTOOL);

        // Set the supported mime types to only redact image/tiff.
        set_config('file_redactor_exifremovermimetype', 'image/tiff');
        $service = new exifremover_service();

        $this->assertTrue($service->is_mimetype_supported('image/tiff'));

        // Other image formats are not supported.
        $this->assertFalse($service->is_mimetype_supported('image/png'));
    }

    /**
     * Tests the EXIF remover service with an unknown filename and an invalid EXIF tool path.
     */
    public function test_exiftool_notfound_filename_unknown(): void {
        $this->resetAfterTest(true);
        set_config('file_redactor_exifremovertoolpath', 'fakeexiftool');

        $service = new exifremover_service();
        $this->expectException(\core\exception\agpu_exception::class);
        $this->expectExceptionMessage(get_string('redactor:exifremover:failedprocessgd', 'core_files'));
        $service->redact_file_by_content('image/jpeg', 'content');
    }

    /**
     * Retrieves the EXIF metadata of a file.
     *
     * @param string $content the content of file.
     * @return string The EXIF metadata as a string.
     */
    private function get_exif_data_from_content(string $content): string {
        $logpath = make_request_directory() . '/temp.jpg';
        file_put_contents($logpath, $content);

        return $this->get_exif_data_from_file($logpath);
    }

    /**
     * Retrieves the EXIF metadata of a file.
     *
     * @param string $filepath the path to the file.
     * @return string The EXIF metadata as a string.
     */
    private function get_exif_data_from_file(string $filepath): string {
        $exif = exif_read_data($filepath);

        $string = "";
        foreach ($exif as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subkey => $subvalue) {
                    $string .= "$subkey: $subvalue\n";
                }
            } else {
                $string .= "$key: $value\n";
            }
        }
        return $string;
    }

    /**
     * Data provider for test_exifremover_service_clean_filename().
     *
     * @return array
     */
    public static function exifremover_service_clean_filename_provider(): array {
        return [
            'Hyphen minus &#x002D' => [
                'filename' => '-if \'$LensModel eq "18-35mm"\'',
                'expected' => 'if $LensModel eq 18-35mm',
            ],
            'Minus &#x2212;' => [
                'filename' => '−filename.jpg',
                'expected' => 'filename.jpg',
            ],
        ];
    }

    /**
     * Helper to require valid testing exiftool configuration.
     */
    private function require_exiftool(): void {
        if (!defined('TEST_PATH_TO_EXIFTOOL')) {
            $this->markTestSkipped('Could not test the EXIF remover service, missing configuration.');
        }

        if (!TEST_PATH_TO_EXIFTOOL) {
            $this->markTestSkipped('Could not test the EXIF remover service, configuration invalid.');
        }

        if (!is_executable(TEST_PATH_TO_EXIFTOOL)) {
            $this->markTestSkipped('Could not test the EXIF remover service, exiftool not executable.');
        }
    }
}
