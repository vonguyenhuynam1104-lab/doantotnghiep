<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. TẠO TÀI KHOẢN ADMIN
        $admin = User::create([
            'name' => 'Quản trị viên Hệ thống',
            'email' => 'admin@jobconnect.vn',
            'phone' => '0988888888',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80',
        ]);

        // 2. TẠO CÁC DANH MỤC NGÀNH NGHỀ
        $categoriesData = [
            [
                'name' => 'Công nghệ Thông tin / Phần mềm',
                'slug' => 'cong-nghe-thong-tin-phan-mem',
                'icon' => 'bi-laptop',
                'description' => 'Lập trình viên Web, Mobile, DevOps, AI, Cloud, An toàn thông tin...',
                'is_featured' => true,
            ],
            [
                'name' => 'Marketing / Truyền thông / QC',
                'slug' => 'marketing-truyen-thong',
                'icon' => 'bi-megaphone',
                'description' => 'Digital Marketing, Content, SEO, Brand Manager, Performance...',
                'is_featured' => true,
            ],
            [
                'name' => 'Thiết kế Đồ họa / UI-UX',
                'slug' => 'thiet-ke-do-hoa-ui-ux',
                'icon' => 'bi-palette',
                'description' => 'UI/UX Designer, Graphic Design, 3D Artist, Motion Graphic...',
                'is_featured' => true,
            ],
            [
                'name' => 'Kinh doanh / Bán hàng',
                'slug' => 'kinh-doanh-ban-hang',
                'icon' => 'bi-graph-up-arrow',
                'description' => 'Sales B2B, Account Executive, Business Development, Telesales...',
                'is_featured' => true,
            ],
            [
                'name' => 'Tài chính / Kế toán / Ngân hàng',
                'slug' => 'tai-chinh-ke-toan-ngan-hang',
                'icon' => 'bi-cash-coin',
                'description' => 'Kiểm toán, Phân tích tài chính, Kế toán tổng hợp, Tín dụng...',
                'is_featured' => true,
            ],
            [
                'name' => 'Nhân sự / Hành chính',
                'slug' => 'nhan-su-hanh-chinh',
                'icon' => 'bi-people',
                'description' => 'Tuyển dụng, C&B, Đào tạo & Phát triển nhân sự, Pháp chế...',
                'is_featured' => true,
            ],
            [
                'name' => 'Thương mại Điện tử / Logistics',
                'slug' => 'thuong-mai-dien-tu-logistics',
                'icon' => 'bi-truck',
                'description' => 'Vận hành sàn E-commerce, Quản lý chuỗi cung ứng, Kho vận...',
                'is_featured' => false,
            ],
            [
                'name' => 'Chăm sóc Khách hàng',
                'slug' => 'cham-soc-khach-hang',
                'icon' => 'bi-headset',
                'description' => 'Customer Care, Hỗ trợ kỹ thuật, Tiếp nhận khiếu nại...',
                'is_featured' => false,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::create($cat);
        }

        // 3. TẠO CÁC DOANH NGHIỆP HÀNG ĐẦU & TÀI KHOẢN TUYỂN DỤNG
        $companiesData = [
            [
                'user' => [
                    'name' => 'HR FPT Software',
                    'email' => 'fpt@jobconnect.vn',
                    'phone' => '02473007300',
                    'role' => 'employer',
                    'password' => Hash::make('password'),
                    'avatar' => 'https://upload.wikimedia.org/wikipedia/commons/1/11/FPT_logo_2010.svg',
                ],
                'company' => [
                    'name' => 'FPT Software',
                    'slug' => 'fpt-software',
                    'logo' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                    'cover_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&auto=format&fit=crop&q=80',
                    'website' => 'https://fptsoftware.com',
                    'email' => 'recruitment@fsoft.com.vn',
                    'phone' => '02473007300',
                    'company_size' => '10,000+ nhân viên',
                    'city' => 'Hà Nội',
                    'address' => 'Tòa nhà FPT Cầu Giấy, Phố Duy Tân, Cầu Giấy, Hà Nội',
                    'industry' => 'Công nghệ Thông tin / Xuất khẩu Phần mềm',
                    'description' => 'FPT Software là công ty xuất khẩu dịch vụ phần mềm hàng đầu tại khu vực Đông Nam Á, hiện diện tại gần 30 quốc gia trên toàn cầu với hơn 30.000 chuyên gia công nghệ.',
                    'is_verified' => true,
                    'is_featured' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Tuyển dụng Viettel',
                    'email' => 'viettel@jobconnect.vn',
                    'phone' => '02462556789',
                    'role' => 'employer',
                    'password' => Hash::make('password'),
                    'avatar' => 'https://images.unsplash.com/photo-1560179707-f14e90ef3623?w=300&auto=format&fit=crop&q=80',
                ],
                'company' => [
                    'name' => 'Tập đoàn Công nghiệp - Viễn thông Viettel',
                    'slug' => 'tap-doan-viettel',
                    'logo' => 'https://images.unsplash.com/photo-1560179707-f14e90ef3623?w=300&auto=format&fit=crop&q=80',
                    'cover_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&auto=format&fit=crop&q=80',
                    'website' => 'https://viettel.com.vn',
                    'email' => 'tuyendung@viettel.com.vn',
                    'phone' => '02462556789',
                    'company_size' => '5,000+ nhân viên',
                    'city' => 'Hà Nội',
                    'address' => 'Lô D26, Khu đô thị mới Cầu Giấy, Phường Yên Hòa, Cầu Giấy, Hà Nội',
                    'industry' => 'Viễn thông & Giải pháp Công nghệ Số',
                    'description' => 'Viettel là Tập đoàn viễn thông và công nghệ số số 1 Việt Nam, tiên phong kiến tạo xã hội số với các giải pháp an ninh mạng, Cloud, AI và viễn thông thế hệ mới.',
                    'is_verified' => true,
                    'is_featured' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'HR VNG Corporation',
                    'email' => 'vng@jobconnect.vn',
                    'phone' => '02839623888',
                    'role' => 'employer',
                    'password' => Hash::make('password'),
                    'avatar' => 'https://images.unsplash.com/photo-1572021335469-31706a17aaef?w=300&auto=format&fit=crop&q=80',
                ],
                'company' => [
                    'name' => 'VNG Corporation',
                    'slug' => 'vng-corporation',
                    'logo' => 'https://images.unsplash.com/photo-1572021335469-31706a17aaef?w=300&auto=format&fit=crop&q=80',
                    'cover_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&auto=format&fit=crop&q=80',
                    'website' => 'https://vng.com.vn',
                    'email' => 'talent@vng.com.vn',
                    'phone' => '02839623888',
                    'company_size' => '3,500+ nhân viên',
                    'city' => 'TP. Hồ Chí Minh',
                    'address' => 'VNG Campus, Đường số 13, Khu chế xuất Tân Thuận, Quận 7, TP.HCM',
                    'industry' => 'Nền tảng Kỹ thuật số & Game Entertainment',
                    'description' => 'VNG là kỳ lân công nghệ đầu tiên của Việt Nam, xây dựng các sản phẩm hàng chục triệu người dùng như Zalo, Zing, ZaloPay và các tựa game nổi tiếng.',
                    'is_verified' => true,
                    'is_featured' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Talent Acquisition MoMo',
                    'email' => 'momo@jobconnect.vn',
                    'phone' => '02854145555',
                    'role' => 'employer',
                    'password' => Hash::make('password'),
                    'avatar' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=300&auto=format&fit=crop&q=80',
                ],
                'company' => [
                    'name' => 'MoMo (Fintech Unicorn)',
                    'slug' => 'momo-fintech',
                    'logo' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=300&auto=format&fit=crop&q=80',
                    'cover_image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=1200&auto=format&fit=crop&q=80',
                    'website' => 'https://momo.vn',
                    'email' => 'careers@momo.vn',
                    'phone' => '02854145555',
                    'company_size' => '2,000+ nhân viên',
                    'city' => 'TP. Hồ Chí Minh',
                    'address' => 'Tòa nhà Phú Mỹ Hưng, Hoàng Văn Thái, Tân Phú, Quận 7, TP.HCM',
                    'industry' => 'Công nghệ Tài chính / Ví điện tử',
                    'description' => 'MoMo là siêu ứng dụng thanh toán và tài chính hàng đầu Việt Nam, phục vụ hơn 31 triệu người dùng với sứ mệnh thúc đẩy thanh toán không tiền mặt và tài chính toàn diện.',
                    'is_verified' => true,
                    'is_featured' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Tuyển dụng VinFast',
                    'email' => 'vinfast@jobconnect.vn',
                    'phone' => '1900232389',
                    'role' => 'employer',
                    'password' => Hash::make('password'),
                    'avatar' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=300&auto=format&fit=crop&q=80',
                ],
                'company' => [
                    'name' => 'VinFast Auto',
                    'slug' => 'vinfast-auto',
                    'logo' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=300&auto=format&fit=crop&q=80',
                    'cover_image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1200&auto=format&fit=crop&q=80',
                    'website' => 'https://vinfastauto.com',
                    'email' => 'tuyendung@vinfast.vn',
                    'phone' => '1900232389',
                    'company_size' => '8,000+ nhân viên',
                    'city' => 'Hải Phòng',
                    'address' => 'Khu kinh tế Đình Vũ - Cát Hải, Huyện Cát Hải, TP. Hải Phòng',
                    'industry' => 'Sản xuất Xe điện & Trí tuệ Nhân tạo Ô tô',
                    'description' => 'VinFast là công ty sản xuất xe điện thông minh toàn cầu thuộc tập đoàn Vingroup, dẫn dắt cuộc cách mạng di chuyển xanh tại Việt Nam và trên thế giới.',
                    'is_verified' => true,
                    'is_featured' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Shopee Careers VN',
                    'email' => 'shopee@jobconnect.vn',
                    'phone' => '02873081221',
                    'role' => 'employer',
                    'password' => Hash::make('password'),
                    'avatar' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=300&auto=format&fit=crop&q=80',
                ],
                'company' => [
                    'name' => 'Shopee Việt Nam',
                    'slug' => 'shopee-viet-nam',
                    'logo' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=300&auto=format&fit=crop&q=80',
                    'cover_image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&auto=format&fit=crop&q=80',
                    'website' => 'https://careers.shopee.vn',
                    'email' => 'recruitment@shopee.vn',
                    'phone' => '02873081221',
                    'company_size' => '4,000+ nhân viên',
                    'city' => 'TP. Hồ Chí Minh',
                    'address' => 'Tòa nhà Saigon Centre, 67 Lê Lợi, Phường Bến Nghé, Quận 1, TP.HCM',
                    'industry' => 'Thương mại Điện tử & Thanh toán Trực tuyến',
                    'description' => 'Shopee là nền tảng thương mại điện tử hàng đầu tại Đông Nam Á và Đài Loan, cung cấp trải nghiệm mua sắm trực tuyến liền mạch, an toàn và hấp dẫn cho hàng triệu người tiêu dùng.',
                    'is_verified' => true,
                    'is_featured' => true,
                ],
            ],
        ];

        $companies = [];
        foreach ($companiesData as $c) {
            $user = User::create($c['user']);
            $compData = $c['company'];
            $compData['user_id'] = $user->id;
            $company = Company::create($compData);
            $companies[$company->slug] = $company;
        }

        // 4. TẠO CÁC ỨNG VIÊN & HỒ SƠ ỨNG VIÊN MẪU
        $candidateUser1 = User::create([
            'name' => 'Nguyễn Văn An',
            'email' => 'ungvien@jobconnect.vn',
            'phone' => '0912345678',
            'role' => 'candidate',
            'password' => Hash::make('password'),
            'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200&auto=format&fit=crop&q=80',
        ]);
        CandidateProfile::create([
            'user_id' => $candidateUser1->id,
            'title' => 'Senior Fullstack Web Developer (PHP/Laravel & Vue/React)',
            'bio' => 'Hơn 4 năm kinh nghiệm phát triển hệ thống web quy mô lớn, RESTful API, tối ưu hóa cơ sở dữ liệu MySQL và kiến trúc Microservices. Đam mê clean code và trải nghiệm người dùng.',
            'experience_years' => 4,
            'expected_salary' => '25 - 35 Triệu',
            'skills' => 'PHP, Laravel, JavaScript, Vue.js, React, MySQL, Docker, Redis, Git, RESTful API',
            'education' => 'Cử nhân Công nghệ Thông tin - Đại học Bách Khoa',
            'city' => 'Hà Nội',
            'address' => 'Quận Cầu Giấy, Hà Nội',
            'linkedin_url' => 'https://linkedin.com/in/nguyenvanan-dev',
            'github_url' => 'https://github.com/nguyenvanan-tech',
            'portfolio_url' => 'https://an-portfolio.dev',
            'is_public' => true,
        ]);

        $candidateUser2 = User::create([
            'name' => 'Trần Thị Mai Linh',
            'email' => 'linh@jobconnect.vn',
            'phone' => '0933221100',
            'role' => 'candidate',
            'password' => Hash::make('password'),
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&auto=format&fit=crop&q=80',
        ]);
        CandidateProfile::create([
            'user_id' => $candidateUser2->id,
            'title' => 'Senior Digital Marketing & Growth Specialist',
            'bio' => 'Chuyên gia hoạch định chiến lược tăng trưởng khách hàng, chạy quảng cáo đa kênh Facebook/Google/TikTok Ads, tối ưu chuyển đổi Funnel và quản trị thương hiệu.',
            'experience_years' => 3,
            'expected_salary' => '18 - 25 Triệu',
            'skills' => 'Digital Marketing, Google Ads, Meta Ads, SEO, Google Analytics 4, Content Strategy, CRM',
            'education' => 'Cử nhân Marketing - Đại học Kinh tế Quốc dân',
            'city' => 'TP. Hồ Chí Minh',
            'address' => 'Quận 1, TP. Hồ Chí Minh',
            'linkedin_url' => 'https://linkedin.com/in/mailinh-mkt',
            'is_public' => true,
        ]);

        $candidateUser3 = User::create([
            'name' => 'Lê Hoàng Tuấn',
            'email' => 'tuan@jobconnect.vn',
            'phone' => '0977665544',
            'role' => 'candidate',
            'password' => Hash::make('password'),
            'avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=200&auto=format&fit=crop&q=80',
        ]);
        CandidateProfile::create([
            'user_id' => $candidateUser3->id,
            'title' => 'UI/UX Product Designer & Design System Lead',
            'bio' => 'Tập trung vào trải nghiệm người dùng, thiết kế giao diện di động & web đẹp mắt, nghiên cứu hành vi người dùng (User Research) và xây dựng thư viện Design System chuẩn quốc tế.',
            'experience_years' => 5,
            'expected_salary' => '28 - 38 Triệu',
            'skills' => 'Figma, Adobe XD, Design System, Prototyping, Wireframing, UX Research, Design Thinking',
            'education' => 'Đại học Kiến trúc TP. Hồ Chí Minh',
            'city' => 'TP. Hồ Chí Minh',
            'address' => 'Quận 3, TP. Hồ Chí Minh',
            'is_public' => true,
        ]);

        // 5. TẠO CÁC TIN TUYỂN DỤNG THỰC TẾ (JOB POSTINGS)
        $jobsData = [
            [
                'company' => 'fpt-software',
                'category' => 'cong-nghe-thong-tin-phan-mem',
                'title' => 'Senior Fullstack Web Developer (Laravel & React/Vue)',
                'slug' => 'senior-fullstack-web-developer-laravel-react-fpt',
                'job_type' => 'Full-time',
                'experience_level' => 'Trưởng nhóm / Senior',
                'salary_min' => 25000000,
                'salary_max' => 45000000,
                'is_negotiable' => false,
                'city' => 'Hà Nội',
                'address' => 'Tòa nhà FPT Cầu Giấy, Phố Duy Tân, Hà Nội',
                'deadline' => now()->addDays(30),
                'quantity' => 5,
                'description' => "• Tham gia thiết kế và xây dựng các hệ thống web enterprise phục vụ hàng triệu người dùng cho các thị trường Nhật Bản, Mỹ và Châu Âu.\n• Xây dựng và tối ưu RESTful API, Microservices kết nối giữa Backend và Frontend.\n• Phối hợp chặt chẽ với Solution Architect và Tech Lead để tối ưu hóa hiệu năng, bảo mật và khả năng mở rộng hệ thống.\n• Hướng dẫn (mentor) cho các thành viên Junior trong dự án.",
                'requirements' => "• Có từ 3-5 năm kinh nghiệm làm việc chuyên sâu với PHP (Laravel Framework) và Modern Frontend (React hoặc Vue.js).\n• Nắm vững kiến thức về OOP, Design Patterns, SOLID principles, Database Indexing & Optimization (MySQL/PostgreSQL).\n• Thành thạo Git, Docker, hiểu biết về CI/CD và triển khai trên AWS/GCP là lợi thế lớn.\n• Tiếng Anh giao tiếp tốt trong công việc.",
                'benefits' => "• Thu nhập hấp dẫn: 25 - 45 triệu/tháng + Thưởng dự án + Lương tháng 13 & thưởng hiệu quả kinh doanh.\n• Gói bảo hiểm sức khỏe cao cấp FPT Care cho bản thân và gia đình.\n• Môi trường làm việc quốc tế, cơ hội Onsite ngắn hạn và dài hạn tại Nhật Bản, Mỹ, Singapore.\n• Được cấp MacBook Pro xịn sò phục vụ công việc.\n• Tham gia các khóa đào tạo chứng chỉ quốc tế tài trợ 100% chi phí.",
                'skills_required' => 'PHP, Laravel, React, Vue.js, MySQL, Docker, RESTful API',
                'views_count' => 342,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'company' => 'tap-doan-viettel',
                'category' => 'cong-nghe-thong-tin-phan-mem',
                'title' => 'Kỹ sư Đám mây & Hạ tầng DevOps / Cloud Architect',
                'slug' => 'ky-su-devops-cloud-architect-viettel',
                'job_type' => 'Full-time',
                'experience_level' => 'Trưởng nhóm / Senior',
                'salary_min' => 30000000,
                'salary_max' => 55000000,
                'is_negotiable' => false,
                'city' => 'Hà Nội',
                'address' => 'Tòa nhà Viettel Cầu Giấy, Hà Nội',
                'deadline' => now()->addDays(25),
                'quantity' => 3,
                'description' => "• Thiết kế, xây dựng và quản trị hạ tầng điện toán đám mây cho các hệ sinh thái viễn thông và dịch vụ số quy mô hàng chục triệu người dùng.\n• Tự động hóa quy trình CI/CD pipelines với Jenkins, GitLab CI, ArgoCD.\n• Giám sát, phát hiện và xử lý sự cố hạ tầng với Prometheus, Grafana, ELK Stack.",
                'requirements' => "• Tối thiểu 3 năm kinh nghiệm thực tế về DevOps/SRE.\n• Thành thạo Kubernetes (K8s), Docker containerization, Terraform, Ansible.\n• Kinh nghiệm sâu rộng về AWS, Google Cloud hoặc Viettel Cloud.\n• Có chứng chỉ CKA, AWS Solutions Architect là điểm cộng lớn.",
                'benefits' => "• Mức lương cạnh tranh: 30 - 55 triệu + Thưởng các ngày lễ, thưởng cuối năm lên tới 4-6 tháng lương.\n• Nghỉ dưỡng hàng năm, bảo hiểm y tế đặc biệt của Tập đoàn Viettel.\n• Cơ hội trực tiếp vận hành hạ tầng viễn thông - hạ tầng số trọng yếu quốc gia.",
                'skills_required' => 'Kubernetes, Docker, CI/CD, AWS, Terraform, Linux, Prometheus',
                'views_count' => 512,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'company' => 'vng-corporation',
                'category' => 'thiet-ke-do-hoa-ui-ux',
                'title' => 'Lead UI/UX Product Designer (Zalo & Digital Entertainment)',
                'slug' => 'lead-ui-ux-product-designer-vng',
                'job_type' => 'Full-time',
                'experience_level' => 'Trưởng nhóm / Senior',
                'salary_min' => 28000000,
                'salary_max' => 45000000,
                'is_negotiable' => false,
                'city' => 'TP. Hồ Chí Minh',
                'address' => 'VNG Campus, Khu chế xuất Tân Thuận, Quận 7, TP.HCM',
                'deadline' => now()->addDays(20),
                'quantity' => 2,
                'description' => "• Định hình ngôn ngữ thiết kế và trải nghiệm người dùng cho các tính năng mới trên ứng dụng Zalo và nền tảng số của VNG.\n• Dẫn dắt nhóm thiết kế xây dựng và duy trì hệ thống Design System chuẩn chỉnh.\n• Phối hợp chặt chẽ với Product Owner và Data Analyst để phân tích hành vi người dùng thông qua A/B Testing.",
                'requirements' => "• Tối thiểu 4 năm kinh nghiệm UI/UX Product Design cho ứng dụng Mobile có lượng người dùng lớn.\n• Thành thạo Figma, Design Tokens, Prototyping tương tác cao.\n• Portfolio thể hiện tư duy thiết kế giải quyết vấn đề (Problem-solving mindset).",
                'benefits' => "• Lương tháng 13 + Thưởng hiệu suất theo kết quả kinh doanh.\n• Làm việc tại VNG Campus chuẩn Silicon Valley: phòng gym, bể bơi, căn tin miễn phí, phòng thư giãn.\n• Gói bảo hiểm sức khỏe VNG Care toàn diện.",
                'skills_required' => 'Figma, UI/UX, Design System, User Research, Mobile App Design, Prototyping',
                'views_count' => 280,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'company' => 'momo-fintech',
                'category' => 'marketing-truyen-thong',
                'title' => 'Chuyên viên Tăng trưởng & Performance Marketing (Fintech)',
                'slug' => 'growth-performance-marketing-momo',
                'job_type' => 'Full-time',
                'experience_level' => 'Nhân viên / Junior-Middle',
                'salary_min' => 18000000,
                'salary_max' => 30000000,
                'is_negotiable' => false,
                'city' => 'TP. Hồ Chí Minh',
                'address' => 'Tòa nhà Phú Mỹ Hưng, Quận 7, TP.HCM',
                'deadline' => now()->addDays(15),
                'quantity' => 3,
                'description' => "• Lập kế hoạch và thực thi các chiến dịch quảng cáo Performance Marketing đa kênh (Facebook Ads, Google App Campaigns, TikTok Ads, Apple Search Ads) nhằm thu hút người dùng mới cho ví MoMo.\n• Phân tích số liệu chuyển đổi (CAC, LTV, ROAS, Retention Rate) để tối ưu chi phí quảng cáo.\n• Thử nghiệm liên tục các thông điệp truyền thông, banner, landing page mới.",
                'requirements' => "• Có từ 2-4 năm kinh nghiệm chạy chiến dịch Performance Marketing, ưu tiên ngành Fintech, E-commerce hoặc Game.\n• Khả năng đọc hiểu số liệu và sử dụng thành thạo Google Analytics 4, AppsFlyer, Adjust, Excel/PowerBI.",
                'benefits' => "• Lương cứng 18 - 30 triệu + Thưởng KPI theo tháng và theo quý.\n• Phúc lợi sinh nhật, du lịch công ty hàng năm, phụ cấp ăn trưa và gửi xe.\n• Môi trường Fintech năng động, trẻ trung, tự do sáng tạo.",
                'skills_required' => 'Performance Marketing, Facebook Ads, Google Ads, AppsFlyer, Data Analysis',
                'views_count' => 195,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'company' => 'vinfast-auto',
                'category' => 'cong-nghe-thong-tin-phan-mem',
                'title' => 'Chuyên gia Trí tuệ Nhân tạo & Xe Tự hành (Autonomous Driving AI)',
                'slug' => 'chuyen-gia-ai-xe-tu-hanh-vinfast',
                'job_type' => 'Full-time',
                'experience_level' => 'Quản lý / Trưởng phòng',
                'salary_min' => 45000000,
                'salary_max' => 80000000,
                'is_negotiable' => false,
                'city' => 'Hà Nội',
                'address' => 'VinFast R&D Center, Hà Nội',
                'deadline' => now()->addDays(40),
                'quantity' => 2,
                'description' => "• Nghiên cứu và phát triển các thuật toán Deep Learning, Computer Vision cho tính năng hỗ trợ lái xe nâng cao (ADAS) và tự hành trên các dòng xe điện VinFast.\n• Xử lý dữ liệu cảm biến đa nguồn: Camera, LiDAR, Radar.\n• Tối ưu mô hình AI chạy trên hệ thống phần cứng nhúng thời gian thực (Nvidia Drive, Snapdragon Ride).",
                'requirements' => "• Tốt nghiệp Thạc sĩ hoặc Tiến sĩ ngành AI/Data Science hoặc có từ 4 năm kinh nghiệm thực tế về Computer Vision & Deep Learning.\n• Thành thạo Python, C++, PyTorch, TensorRT, ROS/ROS2.\n• Có bài báo khoa học hoặc giải thưởng về AI là lợi thế nổi bật.",
                'benefits' => "• Mức lương cực kỳ hấp dẫn từ 45 - 80 triệu/tháng (hoặc cao hơn theo năng lực).\n• Chính sách ưu đãi đặc biệt khi mua nhà Vinhomes, mua xe điện VinFast.\n• Môi trường nghiên cứu đỉnh cao, cơ sở vật chất siêu máy tính hiện đại.",
                'skills_required' => 'Python, C++, PyTorch, Computer Vision, Deep Learning, ROS, Embedded AI',
                'views_count' => 620,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'company' => 'shopee-viet-nam',
                'category' => 'kinh-doanh-ban-hang',
                'title' => 'Key Account Manager (Quản lý Khách hàng Doanh nghiệp Thương hiệu)',
                'slug' => 'key-account-manager-shopee-viet-nam',
                'job_type' => 'Full-time',
                'experience_level' => 'Nhân viên / Junior-Middle',
                'salary_min' => 20000000,
                'salary_max' => 35000000,
                'is_negotiable' => false,
                'city' => 'TP. Hồ Chí Minh',
                'address' => 'Saigon Centre, 67 Lê Lợi, Quận 1, TP.HCM',
                'deadline' => now()->addDays(22),
                'quantity' => 4,
                'description' => "• Quản lý và thúc đẩy doanh số của các nhãn hàng hàng đầu (Shopee Mall) trong các ngành hàng Điện tử, Tiêu dùng nhanh hoặc Thời trang.\n• Tư vấn chiến lược kinh doanh cho nhãn hàng trong các dịp Siêu Sale lớn (Mega Campaign như 9.9, 11.11, 12.12).\n• Đàm phán gói ưu đãi, voucher, hiển thị vị trí đắc địa trên ứng dụng Shopee.",
                'requirements' => "• Có từ 2-4 năm kinh nghiệm Key Account hoặc Business Development trong ngành E-commerce, FMCG, Retail.\n• Kỹ năng giao tiếp, thuyết phục và đàm phán xuất sắc.\n• Khả năng chịu áp lực cao trong các mùa cao điểm chiến dịch.",
                'benefits' => "• Lương cơ bản cạnh tranh 20 - 35 triệu + Thưởng doanh số hấp dẫn.\n• Phụ cấp điện thoại, đi lại, đồ ăn nhẹ & cà phê miễn phí tại văn phòng sang trọng Saigon Centre.\n• Đào tạo kỹ năng quản lý chuyên nghiệp trong môi trường tập đoàn đa quốc gia Sea Group.",
                'skills_required' => 'Key Account Management, Sales B2B, Negotiation, E-commerce, Data Analysis',
                'views_count' => 310,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'company' => 'fpt-software',
                'category' => 'cong-nghe-thong-tin-phan-mem',
                'title' => 'Thực tập sinh Lập trình Web Fullstack (Có lương trợ cấp)',
                'slug' => 'thuc-tap-sinh-lap-trinh-web-fpt-software',
                'job_type' => 'Internship',
                'experience_level' => 'Thực tập sinh',
                'salary_min' => 5000000,
                'salary_max' => 8000000,
                'is_negotiable' => false,
                'city' => 'Đà Nẵng',
                'address' => 'FPT Complex, Đường Nam Kỳ Khởi Nghĩa, Ngũ Hành Sơn, Đà Nẵng',
                'deadline' => now()->addDays(18),
                'quantity' => 10,
                'description' => "• Được đào tạo bài bản trong 2 tháng đầu tiên về quy trình phát triển phần mềm chuẩn quốc tế CMMI và Agile/Scrum.\n• Trực tiếp tham gia vào các dự án phần mềm thật dưới sự dẫn dắt của Senior Developer.\n• Lập trình phát triển các module chức năng với PHP, JavaScript, SQL.",
                'requirements' => "• Sinh viên năm cuối hoặc mới tốt nghiệp chuyên ngành CNTT, Khoa học máy tính.\n• Có kiến thức cơ bản về lập trình web (HTML/CSS/JS/PHP hoặc Java), có đồ án hoặc dự án cá nhân là lợi thế.\n• Chăm chỉ, ham học hỏi và có tinh thần trách nhiệm cao.",
                'benefits' => "• Hỗ trợ lương thực tập: 5.000.000 - 8.000.000 VNĐ/tháng.\n• Cơ hội ký hợp đồng nhân viên chính thức ngay sau khi kết thúc kỳ thực tập.\n• Làm việc tại FPT Complex xanh - sạch - đẹp bên bờ sông Hàn.",
                'skills_required' => 'HTML, CSS, JavaScript, PHP, Git, SQL',
                'views_count' => 450,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'company' => 'momo-fintech',
                'category' => 'tai-chinh-ke-toan-ngan-hang',
                'title' => 'Chuyên viên Phân tích Dữ liệu Tài chính (Financial Data Analyst)',
                'slug' => 'chuyen-vien-phan-tich-du-lieu-tai-chinh-momo',
                'job_type' => 'Full-time',
                'experience_level' => 'Nhân viên / Junior-Middle',
                'salary_min' => 22000000,
                'salary_max' => 38000000,
                'is_negotiable' => false,
                'city' => 'TP. Hồ Chí Minh',
                'address' => 'Tòa nhà Phú Mỹ Hưng, Quận 7, TP.HCM',
                'deadline' => now()->addDays(28),
                'quantity' => 2,
                'description' => "• Xây dựng và duy trì các Dashboard báo cáo tài chính, dòng tiền và lợi nhuận trên Tableau / Power BI.\n• Phân tích hành vi chi tiêu của người dùng, rủi ro tín dụng và hiệu quả các sản phẩm tài chính tiêu dùng.\n• Cung cấp dữ liệu chi tiết cho Ban Giám đốc và các đơn vị kinh doanh đưa ra quyết định chiến lược.",
                'requirements' => "• Tốt nghiệp Đại học chuyên ngành Tài chính, Toán kinh tế, Thống kê hoặc CNTT.\n• Tối thiểu 2 năm kinh nghiệm Data Analyst, thành thạo SQL nâng cao và Python/R.\n• Kỹ năng trực quan hóa dữ liệu (Data Visualization) xuất sắc.",
                'benefits' => "• Lương thỏa thuận xứng đáng: 22 - 38 triệu/tháng.\n• Thưởng tháng 13 + thưởng thành tích năm.\n• Bảo hiểm sức khỏe quốc tế, môi trường làm việc cởi mở, khuyến khích sáng kiến.",
                'skills_required' => 'SQL, Python, Power BI, Tableau, Financial Analysis, Statistical Modeling',
                'views_count' => 230,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'company' => 'vng-corporation',
                'category' => 'nhan-su-hanh-chinh',
                'title' => 'Chuyên viên Tuyển dụng Nhân sự Công nghệ cao (Senior IT Recruiter)',
                'slug' => 'senior-it-recruiter-vng-corporation',
                'job_type' => 'Full-time',
                'experience_level' => 'Trưởng nhóm / Senior',
                'salary_min' => 16000000,
                'salary_max' => 26000000,
                'is_negotiable' => false,
                'city' => 'Hà Nội',
                'address' => 'Chi nhánh VNG Hà Nội, Tòa nhà Charmvit, Trần Duy Hưng, Cầu Giấy',
                'deadline' => now()->addDays(14),
                'quantity' => 2,
                'description' => "• Chịu trách nhiệm săn đầu người và tuyển dụng các vị trí kỹ sư phần mềm cấp cao (Senior/Lead/Architect) cho các dự án trọng điểm.\n• Mở rộng mạng lưới quan hệ (Networking) với cộng đồng Tech tại Việt Nam.\n• Tham gia tổ chức các sự kiện Tech Talk, Hackathon và Employer Branding của VNG.",
                'requirements' => "• Có từ 2-4 năm kinh nghiệm làm IT Recruitment/Headhunter.\n• Hiểu biết tốt về các thuật ngữ công nghệ, xu hướng tuyển dụng thị trường IT.\n• Kỹ năng giao tiếp và thuyết phục ứng viên xuất sắc.",
                'benefits' => "• Lương cứng 16 - 26 triệu + Thưởng hoa hồng tuyển dụng theo từng vị trí (Incentive hấp dẫn).\n• Đầy đủ chế độ phúc lợi cao cấp của VNG.\n• Máy tính xách tay xịn xò, môi trường làm việc năng động sáng tạo.",
                'skills_required' => 'IT Recruitment, Headhunting, Talent Sourcing, Interviewing, Employer Branding',
                'views_count' => 180,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'company' => 'tap-doan-viettel',
                'category' => 'cham-soc-khach-hang',
                'title' => 'Giám sát Trung tâm Chăm sóc Khách hàng Doanh nghiệp (CSKH B2B)',
                'slug' => 'giam-sat-cskh-doanh-nghiep-viettel',
                'job_type' => 'Full-time',
                'experience_level' => 'Nhân viên / Junior-Middle',
                'salary_min' => 14000000,
                'salary_max' => 22000000,
                'is_negotiable' => false,
                'city' => 'Hà Nội',
                'address' => 'Tòa nhà Viettel Cầu Giấy, Hà Nội',
                'deadline' => now()->addDays(20),
                'quantity' => 3,
                'description' => "• Quản lý và giám sát chất lượng cuộc gọi hỗ trợ dịch vụ số (Hóa đơn điện tử, Chữ ký số, Cloud) cho khách hàng doanh nghiệp.\n• Giải quyết các khiếu nại phát sinh phức tạp và đo lường chỉ số hài lòng khách hàng (CSAT/NPS).\n• Đào tạo kỹ năng giao tiếp và nghiệp vụ cho đội ngũ điện thoại viên mới.",
                'requirements' => "• Tốt nghiệp Cao đẳng/Đại học, có từ 2 năm kinh nghiệm giám sát CSKH hoặc Telesales.\n• Giọng nói chuẩn, truyền cảm, không ngọng hay dùng từ địa phương.\n• Kỹ năng xử lý tình huống linh hoạt, bình tĩnh trước áp lực.",
                'benefits' => "• Lương thưởng đầy đủ theo quy chế Tập đoàn Quân đội Viettel.\n• Chế độ BHXH, BHYT, Bảo hiểm thân thể 24/7.\n• Lộ trình thăng tiến rõ ràng lên vị trí Quản lý chi nhánh.",
                'skills_required' => 'Customer Service, CSAT, CRM, Team Leadership, Problem Solving',
                'views_count' => 165,
                'status' => 'published',
                'is_featured' => false,
            ],
        ];

        $createdJobs = [];
        foreach ($jobsData as $j) {
            $comp = $companies[$j['company']];
            $cat = $categories[$j['category']];

            $createdJob = JobPosting::create([
                'company_id' => $comp->id,
                'category_id' => $cat->id,
                'title' => $j['title'],
                'slug' => $j['slug'],
                'job_type' => $j['job_type'],
                'experience_level' => $j['experience_level'],
                'salary_min' => $j['salary_min'],
                'salary_max' => $j['salary_max'],
                'is_negotiable' => $j['is_negotiable'],
                'city' => $j['city'],
                'address' => $j['address'],
                'deadline' => $j['deadline'],
                'quantity' => $j['quantity'],
                'description' => $j['description'],
                'requirements' => $j['requirements'],
                'benefits' => $j['benefits'],
                'skills_required' => $j['skills_required'],
                'views_count' => $j['views_count'],
                'status' => $j['status'],
                'is_featured' => $j['is_featured'],
            ]);
            $createdJobs[] = $createdJob;
        }

        // 6. TẠO HỒ SƠ ỨNG TUYỂN MẪU (APPLICATIONS)
        // Ứng viên Nguyễn Văn An nộp hồ sơ vào FPT Software và VNG
        Application::create([
            'job_posting_id' => $createdJobs[0]->id, // Job FPT
            'user_id' => $candidateUser1->id,
            'candidate_name' => $candidateUser1->name,
            'candidate_email' => $candidateUser1->email,
            'candidate_phone' => $candidateUser1->phone,
            'cover_letter' => 'Kính gửi Quý công ty FPT Software, tôi đã có hơn 4 năm kinh nghiệm phát triển các hệ thống Laravel và Vue.js. Tôi rất ấn tượng với quy mô và môi trường chuyên nghiệp tại FPT Software và mong muốn được cống hiến cho các dự án quốc tế của công ty.',
            'status' => 'interviewing',
            'employer_note' => 'Hồ sơ chuyên môn rất tốt, kỹ năng phù hợp. Hẹn phỏng vấn kỹ thuật vào 14:00 ngày mai.',
            'interview_at' => now()->addDays(2)->setHour(14)->setMinute(0),
        ]);

        Application::create([
            'job_posting_id' => $createdJobs[2]->id, // Job VNG
            'user_id' => $candidateUser3->id,
            'candidate_name' => $candidateUser3->name,
            'candidate_email' => $candidateUser3->email,
            'candidate_phone' => $candidateUser3->phone,
            'cover_letter' => 'Chào team tuyển dụng VNG, tôi là Tuấn, Product Designer với hơn 5 năm kinh nghiệm. Portfolio của tôi có nhiều case study về Mobile App đạt giải thưởng và tôi rất đam mê được đóng góp xây dựng Design System cho Zalo.',
            'status' => 'viewed',
            'employer_note' => 'Đã xem portfolio của ứng viên trên Behance, đang chờ Trưởng bộ phận Design duyệt vòng 1.',
        ]);

        // 7. TẠO VIỆC LÀM ĐÃ LƯU MẪU (SAVED JOBS)
        SavedJob::create([
            'user_id' => $candidateUser1->id,
            'job_posting_id' => $createdJobs[1]->id, // Job Viettel
        ]);

        SavedJob::create([
            'user_id' => $candidateUser1->id,
            'job_posting_id' => $createdJobs[4]->id, // Job VinFast
        ]);
    }
}
