<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Gateways\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\Impl\FileGatewayImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\ExportFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\UploadFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\OneSky\Api\ClientMock;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FileGatewayImplTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED_DOWNLOADED_FILE_1 = __DIR__.'/../../Fixtures/Resources/translations/messages.fr.yml';

    const EXPECTED_DOWNLOADED_FILE_2 = __DIR__.'/../../Fixtures/Resources/translations/subDirectory/messages.fr.yml';

    /**
     * @var FileGatewayImpl
     */
    private $gateway;

    /**
     * @test
     */
    public function upload()
    {
        $uploadFileStub1 = new UploadFileStub1();
        $this->gateway->upload($uploadFileStub1);
        $this->assertEquals(ClientMock::$action, FileGateway::UPLOAD_METHOD);
        $this->assertEquals(
            ClientMock::$parameters,
            [
                [
                    UploadFile::PROJECT_ID       => UploadFileStub1::PROJECT_ID,
                    UploadFile::SOURCE_FILE_PATH => $uploadFileStub1->getFormattedFilePath(),
                    UploadFile::FILE_FORMAT      => UploadFileStub1::FILE_FORMAT,
                    UploadFile::SOURCE_LOCALE    => UploadFileStub1::SOURCE_LOCALE,
                ],
            ]
        );
    }

    /**
     * @test
     */
    public function Client400_download_Continur()
    {
        $this->gateway->setClient(new ClientMock('{"meta":{"status":400,"message":"Invalid source file"},"data":{}}'));
        $this->gateway->downloadFile(new ExportFileStub1());
    }
    /**
     * @test
     */
    public function download()
    {
        $exportFileStub1 = new ExportFileStub1();
        $this->gateway->downloadFile($exportFileStub1);
        $this->assertEquals(ClientMock::$action, FileGateway::DOWNLOAD_METHOD);
        $this->assertEquals(
            ClientMock::$parameters,
            [
                [
                    ExportFile::PROJECT_ID                 => ExportFileStub1::PROJECT_ID,
                    ExportFile::REQUESTED_LOCALE           => ExportFileStub1::REQUESTED_LOCALE,
                    ExportFile::REQUESTED_SOURCE_FILE_NAME => $exportFileStub1->getEncodedSourceFileName(),
                ]
            ]
        );
        $this->assertStringEqualsFile(self::EXPECTED_DOWNLOADED_FILE_1, 'Download : 1');
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
