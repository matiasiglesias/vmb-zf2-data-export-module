<?php
namespace VMBDataExport\Export;
use Doctrine\ORM\EntityManager;
use mikehaertl\wkhtmlto\Pdf;

class PDFExport implements ExportDataServiceInterface
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $html;

    /**
     * @var string
     */
    private $link;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function writeData(array $dados)
    {
    }

    public function export()
    {
        $name = md5(rand(0, 999)) . '.pdf';
        $path = __DIR__ . '/../../../../../../public/pdf/';
        $pdf = new Pdf();

        if ($this->link) {
            $pdf->addPage($this->link);
        }

        if ($this->html) {
            $pdf->addPage($this->html);
        }

        if ($this->path) {
            $pdf->addPage($this->path);
        }

        $pdf->saveAs($path . $name);
        return '/pdf/'.$name;
    }

    /**
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function writeCustomData(array $data, array $headers)
    {
        $this->link = isset($data['link']) ? $data['link'] : false;
        $this->html = isset($data['html']) ? $data['html'] : false;
        $this->path = isset($data['path']) ? $data['path'] : false;
    }
}
