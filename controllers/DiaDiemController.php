<?php
require_once './models/DiaDiemModel.php';

class DiaDiemController
{
    public $modelDiaDiem;

    public function __construct()
    {
        $this->modelDiaDiem = new DiaDiemModel();
    }

    public function danhSachDiaDiem()
    {
        $listDiaDiem = $this->modelDiaDiem->getAllDiaDiem();
        require_once './views/tours/danhsach_DiaDiem.php';
    }

    public function viewThemDiaDiem()
    {
        $listTour = $this->modelDiaDiem->getAllTours();
        require_once './views/tours/them_DiaDiem.php';
    }

    public function themDiaDiem($data)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];
            if (empty($data['ten'])) {
                $errors['ten'] = 'Tên địa điểm không được để trống';
            }
            if (empty($data['tgDi'])) {
                $errors['tgDi'] = 'Thời gian đi không được để trống';
            }
            if (empty($data['tgVe'])) {
                $errors['tgVe'] = 'Thời gian về không được để trống';
            }

            if (empty($errors)) {
                // Calculate next order if tour_id is present
                if (!empty($data['tour_id'])) {
                    $loai = $data['loai'] ?? 'destination';
                    $maxThuTu = $this->modelDiaDiem->getMaxThuTu($data['tour_id'], $loai);
                    $data['thuTu'] = $maxThuTu + 1;
                } else {
                    $data['thuTu'] = 1;
                }

                $this->modelDiaDiem->insertDiaDiem($data);
                header('Location: ?act=quan-ly-dia-diem');
                exit();
            } else {
                $listTour = $this->modelDiaDiem->getAllTours();
                require_once './views/tours/them_DiaDiem.php';
            }
        }
    }

    public function viewCapNhatDiaDiem($id)
    {
        $diaDiem = $this->modelDiaDiem->getDiaDiemById($id);
        $listTour = $this->modelDiaDiem->getAllTours();
        if ($diaDiem) {
            require_once './views/tours/capnhat_DiaDiem.php';
        } else {
            header('Location: ?act=quan-ly-dia-diem');
            exit();
        }
    }

    public function capNhatDiaDiem($id, $data)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];
            if (empty($data['ten'])) {
                $errors['ten'] = 'Tên địa điểm không được để trống';
            }
            if (empty($data['tgDi'])) {
                $errors['tgDi'] = 'Thời gian đi không được để trống';
            }
            if (empty($data['tgVe'])) {
                $errors['tgVe'] = 'Thời gian về không được để trống';
            }

            if (empty($errors)) {
                $this->modelDiaDiem->updateDiaDiem($id, $data);
                header('Location: ?act=quan-ly-dia-diem');
                exit();
            } else {
                $diaDiem = $this->modelDiaDiem->getDiaDiemById($id);
                $listTour = $this->modelDiaDiem->getAllTours();
                require_once './views/tours/capnhat_DiaDiem.php';
            }
        }
    }

    public function xoaDiaDiem($id)
    {
        $this->modelDiaDiem->deleteDiaDiem($id);
        header('Location: ?act=quan-ly-dia-diem');
        exit();
    }

    public function updateOrder()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (isset($input['items']) && is_array($input['items'])) {
            foreach ($input['items'] as $item) {
                if (isset($item['id']) && isset($item['thuTu'])) {
                    $this->modelDiaDiem->updateOrder($item['id'], $item['thuTu']);
                }
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        }
        exit;
    }
}
