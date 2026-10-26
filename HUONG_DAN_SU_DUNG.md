# 🚀 ĐỒ ÁN TỐT NGHIỆP: HỆ THỐNG TÌM KIẾM VIỆC LÀM & KẾT NỐI TUYỂN DỤNG TRỰC TUYẾN (JOBCONNECT)

Hệ thống web kết nối giữa **Người tìm việc (Ứng viên)** và **Doanh nghiệp (Nhà tuyển dụng)**, tích hợp bảng quản trị **Admin**, xây dựng theo kiến trúc **Laravel MVC & MySQL**.

---

## 🗄️ 1. THÔNG TIN CƠ SỞ DỮ LIỆU MYSQL

- **Hệ quản trị CSDL:** MySQL / MariaDB (XAMPP Port: `3306`)
- **Tên Database:** `doantotnhiep_jobs`
- **Tài khoản mặc định:** `root` | Mật khẩu: *(để trống)*
- **Bộ mã ký tự:** `utf8mb4_unicode_ci` (Hỗ trợ tiếng Việt có dấu đầy đủ)
- **File Export CSDL (.sql):**
  - [doantotnhiep_jobs.sql](file:///c:/xampp/htdocs/doantotnhiep/doantotnhiep_jobs.sql) (nằm ngay tại thư mục gốc dự án)
  - [database/doantotnhiep_jobs.sql](file:///c:/xampp/htdocs/doantotnhiep/database/doantotnhiep_jobs.sql)

> 💡 **Cách import vào phpMyAdmin:**
> 1. Mở trình duyệt vào `http://localhost/phpmyadmin`
> 2. Tạo mới cơ sở dữ liệu tên: `doantotnhiep_jobs`
> 3. Chọn tab **Nhập (Import)** -> Chọn file `doantotnhiep_jobs.sql` -> Nhấn **Thực hiện (Go)**.

---

## 🔑 2. TÀI KHOẢN MẪU DÙNG ĐỂ CHẤM ĐIỂM & DEMO

*(Mật khẩu chung cho tất cả tài khoản mẫu là: `password`)*

| Vai trò (Role) | Email đăng nhập | Mật khẩu | Chức năng chính |
| :--- | :--- | :--- | :--- |
| **Ứng viên (Candidate)** | `ungvien@jobconnect.vn` | `password` | Tìm việc, lọc lương/địa điểm, nộp CV đính kèm, quản lý việc đã nộp, theo dõi lịch phỏng vấn, lưu tin |
| **Ứng viên 2** | `linh@jobconnect.vn` | `password` | Ứng viên ngành Marketing (Hồ sơ đầy đủ) |
| **Ứng viên 3** | `tuan@jobconnect.vn` | `password` | Ứng viên UI/UX Designer |
| **Nhà tuyển dụng (FPT)** | `fpt@jobconnect.vn` | `password` | Đăng tin, sửa tin, duyệt CV, đổi trạng thái ứng viên, hẹn lịch phỏng vấn, quản trị công ty |
| **Nhà tuyển dụng (Viettel)** | `viettel@jobconnect.vn` | `password` | Tập đoàn Viettel Telecom |
| **Nhà tuyển dụng (VNG)** | `vng@jobconnect.vn` | `password` | VNG Corporation |
| **Nhà tuyển dụng (MoMo)** | `momo@jobconnect.vn` | `password` | MoMo Fintech |
| **Quản trị viên (Admin)** | `admin@jobconnect.vn` | `password` | Tổng quan dashboard, duyệt/khóa người dùng, cấp tích xanh công ty, quản lý việc làm & danh mục |

*Giao diện trang Đăng nhập đã có sẵn 3 nút nhấn nhanh (Quick-fill) để giảng viên/người dùng click vào là tự điền tài khoản mẫu ngay lập tức mà không cần gõ bàn phím.*

---

## 🌐 3. CÁCH TRUY CẬP WEBSITE

Bạn có thể chạy dự án bằng **1 trong 2 cách** sau:

### Cách 1: Chạy trực tiếp qua máy chủ XAMPP Apache
- Khởi động Apache & MySQL trên XAMPP Control Panel.
- Truy cập trình duyệt theo địa chỉ trực tiếp:  
  👉 **`http://localhost/doantotnhiep`** *(Đã cấu hình tự động vào thẳng trang web, không cần gõ `/public` và không bao giờ bị hiện "Index of")*

### Cách 2: Chạy qua Artisan CLI
- Mở terminal tại thư mục `c:\xampp\htdocs\doantotnhiep` và gõ:
  ```bash
  php artisan serve
  ```
- Truy cập trình duyệt theo địa chỉ:  
  👉 **`http://127.0.0.1:8000`**

---

## 🏗️ 4. KIẾN TRÚC & SƠ ĐỒ BẢNG CƠ SỞ DỮ LIỆU MYSQL

1. **`users`**: Quản lý tài khoản (id, name, email, phone, role: `candidate`/`employer`/`admin`, avatar, is_active).
2. **`candidate_profiles`**: Hồ sơ ứng viên (chức danh, số năm kinh nghiệm, mức lương mong muốn, kỹ năng, file CV đính kèm, học vấn, link GitHub/LinkedIn/Portfolio, trạng thái công khai).
3. **`categories`**: Danh mục ngành nghề tuyển dụng (CNTT, Marketing, Thiết kế, Bán hàng, Tài chính ngân hàng, Nhân sự, v.v.).
4. **`companies`**: Hồ sơ công ty/doanh nghiệp (tên, logo, ảnh bìa banner, quy mô nhân sự, tỉnh thành, địa chỉ, website, lĩnh vực, tích xanh xác thực `is_verified`).
5. **`job_postings`**: Tin tuyển dụng (tiêu đề, công ty, ngành nghề, hình thức làm việc Full-time/Part-time/Remote, cấp bậc, khoảng lương min-max hoặc thỏa thuận, hạn nộp, mô tả, yêu cầu, quyền lợi, kỹ năng yêu cầu, lượt xem, trạng thái `published`/`closed`).
6. **`applications`**: Đơn nộp hồ sơ ứng tuyển (việc làm, ứng viên, họ tên, email, sđt, file CV, thư giới thiệu, trạng thái: *pending -> viewed -> interviewing -> accepted -> rejected*, ghi chú phản hồi của nhà tuyển dụng, ngày giờ hẹn phỏng vấn).
7. **`saved_jobs`**: Việc làm ứng viên đã lưu lại để theo dõi.
