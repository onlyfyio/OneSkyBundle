<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Gateways\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\Impl\FileGatewayImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\ExportFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\ExportFileStub2;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\UploadFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\UploadFileStub2;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\OneSky\Api\ClientMock;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FileGatewayImplTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED_DOWNLOADED_FILE_1 = __DIR__.'/../../Fixtures/Resources/translations/messages.fr.yml';

    const EXPECTED_DOWNLOADED_FILE_2 = __DIR__.'/../../Fixtures/Resources/translations/subDirectory/messages.fr.yml';

    /**
     * @var FileGateway
     */
    private $gateway;

    /**
     * @test
     */
    public function WithoutFiles_upload_DoNothing()
    {
        $this->gateway->upload([]);
        $this->assertNull(ClientMock::$action);
    }

    /**
     * @test
     */
    public function OneFile_upload()
    {
        $uploadFileStub1 = new UploadFileStub1();
        $this->gateway->upload([$uploadFileStub1]);
        $this->assertEquals(ClientMock::$action, FileGateway::UPLOAD_METHOD);
        $this->assertEquals(
            ClientMock::$parameters,
            [
                [
                    [
                        UploadFile::PROJECT_ID       => UploadFileStub1::PROJECT_ID,
                        UploadFile::SOURCE_FILE_PATH => $uploadFileStub1->getFormattedFilePath(),
                        UploadFile::FILE_FORMAT      => UploadFileStub1::FILE_FORMAT,
                        UploadFile::SOURCE_LOCALE    => UploadFileStub1::SOURCE_LOCALE,
                    ],
                ],
            ]
        );
    }

    /**
     * @test
     */
    public function ManyFiles_upload_Upload()
    {
        $uploadFileStub1 = new UploadFileStub1();
        $uploadFileStub2 = new UploadFileStub2();
        $this->gateway->upload([$uploadFileStub1, $uploadFileStub2]);
        $this->assertEquals(ClientMock::$action, FileGateway::UPLOAD_METHOD);
        $this->assertEquals(
            ClientMock::$parameters,
            [
                [
                    [
                        UploadFile::PROJECT_ID       => UploadFileStub1::PROJECT_ID,
                        UploadFile::SOURCE_FILE_PATH => $uploadFileStub1->getFormattedFilePath(),
                        UploadFile::FILE_FORMAT      => UploadFileStub1::FILE_FORMAT,
                        UploadFile::SOURCE_LOCALE    => UploadFileStub1::SOURCE_LOCALE,
                    ],
                    [
                        UploadFile::PROJECT_ID       => UploadFileStub2::PROJECT_ID,
                        UploadFile::SOURCE_FILE_PATH => $uploadFileStub2->getFormattedFilePath(),
                        UploadFile::FILE_FORMAT      => UploadFileStub2::FILE_FORMAT,
                        UploadFile::SOURCE_LOCALE    => UploadFileStub2::SOURCE_LOCALE,
                    ],
                ],
            ]
        );
    }

    /**
     * @test
     */
    public function WithoutFile_download_DoNothing()
    {
        $this->gateway->download([]);
        $this->assertNull(ClientMock::$action);
    }

    /**
     * @test
     */
    public function WithOneFile_download_Download()
    {
        $exportFileStub1 = new ExportFileStub1();
        $this->gateway->download([$exportFileStub1]);
        $this->assertEquals(ClientMock::$action, FileGateway::DOWNLOAD_METHOD);
        $this->assertEquals(
            ClientMock::$parameters,
            [
                [
                    ExportFile::PROJECT_ID                 => ExportFileStub1::PROJECT_ID,
                    ExportFile::REQUESTED_LOCALE           => ExportFileStub1::REQUESTED_LOCALE,
                    ExportFile::REQUESTED_SOURCE_FILE_NAME => $exportFileStub1->getEncodedSourceFileName(),
                ],
            ]
        );
        $this->assertStringEqualsFile(self::EXPECTED_DOWNLOADED_FILE_1, 'Download : 1');
    }

    /**
     * @test
     */
    public function WithManyFiles_upload_Upload()
    {
        $exportFileStub1 = new ExportFileStub1();
        $exportFileStub2 = new ExportFileStub2();
        $this->gateway->download([$exportFileStub1, $exportFileStub2]);
        $this->assertEquals(ClientMock::$action, FileGateway::DOWNLOAD_METHOD);
        $this->assertEquals(
            ClientMock::$parameters,
            [
                [
                    ExportFile::PROJECT_ID                 => ExportFileStub1::PROJECT_ID,
                    ExportFile::REQUESTED_LOCALE           => ExportFileStub1::REQUESTED_LOCALE,
                    ExportFile::REQUESTED_SOURCE_FILE_NAME => $exportFileStub1->getEncodedSourceFileName(),
                ],
                [
                    ExportFile::PROJECT_ID                 => ExportFileStub2::PROJECT_ID,
                    ExportFile::REQUESTED_LOCALE           => ExportFileStub2::REQUESTED_LOCALE,
                    ExportFile::REQUESTED_SOURCE_FILE_NAME => $exportFileStub2->getEncodedSourceFileName(),
                ],
            ]
        );
        $this->assertStringEqualsFile(self::EXPECTED_DOWNLOADED_FILE_1, 'Download : 1');
        $this->assertStringEqualsFile(self::EXPECTED_DOWNLOADED_FILE_2, 'Download : 2');
    }

    protected function setUp()
    {
        $this->gateway = new FileGatewayImpl();
        $this->gateway->setClient(new ClientMock());
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        file_exists(self::EXPECTED_DOWNLOADED_FILE_1) ? unlink(self::EXPECTED_DOWNLOADED_FILE_1) : null;
        file_exists(self::EXPECTED_DOWNLOADED_FILE_2) ? unlink(self::EXPECTED_DOWNLOADED_FILE_2) : null;
    }
}
