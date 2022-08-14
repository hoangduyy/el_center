import { lazy } from "react";
import {
    BookOutlined,
    ContactsOutlined,
    DashboardOutlined,
    PieChartOutlined,
    NotificationOutlined,
    SettingOutlined,
    HddOutlined,
    HomeOutlined,
    BankOutlined,
    ScheduleOutlined,
    UserOutlined,
} from "@ant-design/icons";


const NotFoundPage = lazy(() => import("./pages/404"));
const Dashboard = lazy(() => import("./pages/dashboard"));
const ReportRevenue = lazy(() => import("./pages/report/revenue"));
const ReportProduct = lazy(() => import("./pages/report/product"));
const ReportCustomer = lazy(() => import("./pages/report/customer"));

const ProfilePage = lazy(() => import("./pages/profile"));


const ContactPage = lazy(() => import("./pages/contact"));
const CreateContactPage = lazy(() => import("./pages/contact/new"));
const EditContactPage = lazy(() => import("./pages/contact/edit"));

const BlogCategoryPage = lazy(() => import("./pages/blog_category"));
const CreateBlogCategoryPage = lazy(() => import("./pages/blog_category/new"));
const EditBlogCategoryPage = lazy(() => import("./pages/blog_category/edit"));

const BlogPostPage = lazy(() => import("./pages/blog-post"));
const CreateBlogPostPage = lazy(() => import("./pages/blog-post/new"));
const EditBlogPostPage = lazy(() => import("./pages/blog-post/edit"));


const CoursePage = lazy(() => import("./pages/course"));
const CreateCoursePage = lazy(() => import("./pages/course/new"));
const EditCoursePage = lazy(() => import("./pages/course/edit"));

const LevelPage = lazy(() => import("./pages/course/level"));
const CreateLevelPage = lazy(() => import("./pages/course/level/new"));
const EditLevelPage = lazy(() => import("./pages/course/level/edit"));

const ClassPage = lazy(() => import("./pages/class"));
const CreateClassPage = lazy(() => import("./pages/class/new"));
const EditClassPage = lazy(() => import("./pages/class/edit"));
const DetailClassPage = lazy(() => import("./pages/class/detail"));
const DetailStudentPage = lazy(() => import("./pages/class/student-detail"));

const OrderPage = lazy(() => import("./pages/order"));
const CreateOrderPage = lazy(() => import("./pages/order/new"));
const EditOrderPage = lazy(() => import("./pages/order/edit"));

const OrderHistoryPage = lazy(() => import("./pages/order-history"));
const CreateOrderHistoryPage = lazy(() => import("./pages/order-history/new"));
const EditOrderHistoryPage = lazy(() => import("./pages/order-history/edit"));


const BranchPage = lazy(() => import("./pages/branch"));
const CreateBranchPage = lazy(() => import("./pages/branch/new"));
const EditBranchPage = lazy(() => import("./pages/branch/edit"));

const RoomPage = lazy(() => import("./pages/branch/room"));
const CreateRoomPage = lazy(() => import("./pages/branch/room/new"));
const EditRoomPage = lazy(() => import("./pages/branch/room/edit"));

const ClassSchedulePage = lazy(() => import("./pages/class-schedule"));
const CreateClassSchedulePage = lazy(() => import("./pages/class-schedule/new"));
const EditClassSchedulePage = lazy(() => import("./pages/class-schedule/edit"));

const StudentCoursePage = lazy(() => import("./pages/student_course"));

const TeacherPage = lazy(() => import("./pages/teacher"));
const CreatTeacherPage = lazy(() => import("./pages/teacher/new"));
const EditTeacherPage = lazy(() => import("./pages/teacher/edit"));

const TeacherSchedule = lazy(() => import("./pages/teacher-schedule"));

const TimeKeeping = lazy(() => import("./pages/time-keeping"));

const DegreePage = lazy(() => import("./pages/degree"));
const CreateDegreePage = lazy(() => import("./pages/degree/new"));
const EditDegreePage = lazy(() => import("./pages/degree/edit"));

const CertificatePage = lazy(() => import("./pages/certificate"));
const CreateCertificatePage = lazy(() => import("./pages/certificate/new"));
const EditCertificatePage = lazy(() => import("./pages/certificate/edit"));

const StudentPage = lazy(() => import("./pages/student"));
const CreateStudentPage = lazy(() => import("./pages/student/new"));
const EditStudentPage = lazy(() => import("./pages/student/edit"));


const CreateStudentPointPage = lazy(() => import("./pages/student-point/new"));
const EditStudentPointPage = lazy(() => import("./pages/student-point/edit"));

const ListQuestionPage = lazy(() => import("./pages/question"));
const CreateQuestionPage = lazy(() => import("./pages/question/new"));
const EditQuestionPage = lazy(() => import("./pages/question/edit"));


const routes = [
    {
        path: "dashboard",
        title: "Tổng quan",
        icon: <DashboardOutlined />,
        component: Dashboard,
        roles: ['admin','manage']
    },
    {
        path: "report",
        title: "Báo cáo",
        icon: <PieChartOutlined />,
        childs: [
            {
                title: "Báo cáo doanh thu",
                path: "revenue",
                component: ReportRevenue,
            },
            {
                path: "product",
                title: "Báo cáo lớp học",
                component: ReportProduct,
            },
            {
                path: "customer",
                title: "Báo cáo học viên",
                component: ReportCustomer,
            },
        ],
        roles: ['admin','manage']
    },
    {
        path: "branch",
        title: "Chi nhánh",
        icon: <BankOutlined />,
        childs: [
            {
                title: "Quản lý chi nhánh",
                path: "",
                component: BranchPage,
            },
            {
                path: "new",
                title: "Thêm chi nhánh",
                component: CreateBranchPage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa chi nhánh",
                hidden: true,
                component: EditBranchPage,
            },
            {
                title: "Quản lý phòng học",
                path: "room",
                component: RoomPage,
            },
            {
                path: "room/new",
                title: "Thêm phòng học",
                component: CreateRoomPage,
                hidden: true,
            },
            {
                path: "room/:id",
                title: "Sửa phòng học",
                hidden: true,
                component: EditRoomPage,
            },
        ],
        roles: ['admin','manage']
    },
    {
        path: "class",
        title: "Lớp học",
        icon: <HomeOutlined/>,
        childs: [
            {
                title: "Quản lý lớp học",
                path: "",
                component: ClassPage,
            },
            {
                path: "new",
                title: "Thêm lớp học",
                component: CreateClassPage,
                hidden: true,
            },
            {
                path: "detail/:id",
                title: "Chi tiết lớp học",
                hidden: true,
                component: DetailClassPage,
            },
            {
                path: "student-detail/:id/:classId",
                title: "Thông tin học viên",
                hidden: true,
                component: DetailStudentPage,
            },
            {
                path: ":id",
                title: "Sửa lớp học",
                hidden: true,
                component: EditClassPage,
            },
        ],
        roles: ['admin','manage','teacher']
    },
    {
        path: "student-point",
        title: "Điểm học viên",
        hidden: true,
        childs: [
            {
                title: "Thêm điểm học viên",
                path: "new/:id/:classId",
                component: CreateStudentPointPage,
                hidden: true,
            },
            {
                title: "Chỉnh sửa điểm học viên",
                path: ":id/:classId/:pointId",
                component: EditStudentPointPage,
                hidden: true,
            },
        ],
        roles: ['admin','manage']
    },
    {
        path: "course",
        title: "Khoá học",
        icon: <BookOutlined />,
        childs: [
            {
                title: "Quản lý khoá học",
                path: "",
                component: CoursePage,
            },
            {
                path: "new",
                title: "Thêm liên hệ",
                component: CreateCoursePage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa liên hệ",
                hidden: true,
                component: EditCoursePage,
            },
            {
                title: "Quản lý trình độ",
                path: "level",
                component: LevelPage,
            },
            {
                path: "level/new",
                title: "Thêm trình độ",
                component: CreateLevelPage,
                hidden: true,
            },
            {
                path: "level/:id",
                title: "Sửa trình độ",
                hidden: true,
                component: EditLevelPage,
            },
        ],
        roles: ['admin','manage']
    },
    {
        path: "student/course",
        title: "Khoá học hs",
        icon: <BookOutlined />,
        childs: [
            {
                title: "Khoá học đăng ký",
                path: "",
                component: StudentCoursePage,
            },
        ],
    },

    {
        path: "class-schedule",
        title: "Thời khoá biểu",
        icon: <ScheduleOutlined />,
        childs: [
            {
                title: "Quản lý TKB",
                path: "",
                component: ClassSchedulePage,
            },
            {
                path: "new",
                title: "Thêm thời khoá biểu",
                component: CreateClassSchedulePage,
                hidden: true
            },
            {
                path: ":id",
                title: "Sửa đơn đăng ký",
                hidden: true,
                component: EditClassSchedulePage,
            },
        ],
        roles: ['admin','manage']
    },
    {
        path: "order",
        title: "Đơn đăng ký",
        icon: <HddOutlined />,
        childs: [
            {
                title: "Quản lý đơn đăng ký",
                path: "",
                component: OrderPage,
            },
            {
                path: "new",
                title: "Thêm đơn đăng ký",
                component: CreateOrderPage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa đơn đăng ký",
                hidden: true,
                component: EditOrderPage,
            },
        ],
        roles: ['admin','manage','student']
    },
    {
        path: "order-history",
        title: "Chi tiết nạp học phí",
        hidden: true,
        childs: [
            {
                path: "new/:orderId",
                title: "Thêm đơn đăng ký",
                component: CreateOrderHistoryPage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa đơn đăng ký",
                hidden: true,
                component: EditOrderHistoryPage,
            },
        ],
        roles: ['admin','manage','student']
    },
    {
        path: "teacher",
        title: "Giáo viên",
        icon: <UserOutlined />,
        childs: [
            {
                title: "Quản lý giáo viên",
                path: "",
                component: TeacherPage,
            },
            {
                path: "new",
                title: "Thêm giáo viên",
                component: CreatTeacherPage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa giáo viên",
                hidden: true,
                component: EditTeacherPage,
            },
        ],
        roles: ['admin']
    },
    {
        path: "student",
        title: "Học viên",
        icon: <ContactsOutlined />,
        childs: [
            {
                title: "Quản lý học viên",
                path: "",
                component: StudentPage,
            },
            {
                path: "new",
                title: "Thêm học viên",
                component: CreateStudentPage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa học viên",
                hidden: true,
                component: EditStudentPage,
            },
        ],
        roles: ['admin']
    },
    {
        path: "blog",
        title: "Tin tức",
        icon: <NotificationOutlined />,
        childs: [
            {
                title: "Quản lý tin tức",
                path: "category",
                component: BlogCategoryPage,
            },
            {
                path: "category/new",
                title: "Thêm tin tức",
                component: CreateBlogCategoryPage,
                hidden: true,
            },
            {
                path: "category/:id",
                title: "Sửa tin tức",
                hidden: true,
                component: EditBlogCategoryPage,
            },
            {
                title: "Quản lý bài viết",
                path: "post",
                component: BlogPostPage,
            },
            {
                path: "post/new",
                title: "Thêm bài viết",
                component: CreateBlogPostPage,
                hidden: true,
            },
            {
                path: "post/:id",
                title: "Sửa bài viết",
                hidden: true,
                component: EditBlogPostPage,
            },
        ],
        roles: ['admin','manage']
    },
    {
        path: "teacher-schedule",
        title: "TKB GV",
        icon: <SettingOutlined />,
        component: TeacherSchedule,
        roles: ['teacher']
    },
    {
        path: "teacher-schedule",
        title: "TKB HS",
        icon: <SettingOutlined />,
        component: TeacherSchedule,
        roles: ['student']
    },
    {
        path: "time-keeping",
        title: "Chấm công",
        icon: <SettingOutlined />,
        component: TimeKeeping,
        roles: ['admin','manage','teacher']
    },
    {
        path: "contact",
        title: "Liên hệ",
        icon: <ContactsOutlined />,
        childs: [
            {
                title: "Quản lý liên hệ",
                path: "",
                component: ContactPage,
            },
            {
                path: "new",
                title: "Thêm liên hệ",
                component: CreateContactPage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa liên hệ",
                hidden: true,
                component: EditContactPage,
            },
        ],
        roles: ['admin','manage']
    },
    {
        path: "degree",
        title: "Học vị",
        icon: <ContactsOutlined />,
        childs: [
            {
                title: "Quản lý học vị",
                path: "",
                component: DegreePage,
            },
            {
                path: "new",
                title: "Thêm học vị",
                component: CreateDegreePage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa học vị",
                hidden: true,
                component: EditDegreePage,
            },
        ],
        roles: ['admin']
    },
    {
        path: "certificate",
        title: "Chứng chỉ",
        icon: <ContactsOutlined />,
        childs: [
            {
                title: "Quản lý chứng chỉ",
                path: "",
                component: CertificatePage,
            },
            {
                path: "new",
                title: "Thêm học vị",
                component: CreateCertificatePage,
                hidden: true,
            },
            {
                path: ":id",
                title: "Sửa học vị",
                hidden: true,
                component: EditCertificatePage,
            },
        ],
        roles: ['admin']
    },
    {
        path: "question",
        title: "Bộ câu hỏi",
        icon: <ContactsOutlined />,
        childs: [
            {
                title: "Danh sách",
                path: "",
                component: ListQuestionPage,
            },
            {
                title: "Tạo mới",
                path: "new",
                component: CreateQuestionPage,
            },
            {
                title: "Cập nhật",
                path: ":id/edit",
                component: EditQuestionPage,
                hidden: true,
            },
        ],
        roles: ['admin']
    },
    {
        path: "profile",
        title: "Hồ sơ",
        icon: <SettingOutlined />,
        component: ProfilePage,
        roles: ['admin','manage','student','teacher']
    },
    {
        path: "/admin/*",
        title: "404",
        hidden: true,
        component: NotFoundPage,
        roles: ['admin','manage','student','teacher']
    },


];

export default routes;
