const {
    Button,
    Table,
    Popconfirm,
    message,
    Input,
    Space,
    Card,
    Form,
} = require("antd");
import { DeleteFilled, EditFilled, CopyOutlined } from "@ant-design/icons";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient, useQuery } from "react-query";
import { Link, useLocation } from "react-router-dom";
import { css } from "@emotion/react";
import { useEffect, useState } from "react";
import { useDebounce } from "../../../lib/hook";
import axios from "axios";
import moment from "moment";
import Calendar from "../../components/calendar";
import Avatar from "antd/lib/avatar/avatar";

const ProfilePage = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [search, setSearch] = useState(null);
    const [startDate, setStartDate] = useState();
    const [endDate, setEndDate] = useState();
    const [data, setData] = useState([]);
    const [isloading, setIsLoading] = useState(false);
    const userInfo = JSON.parse(localStorage.getItem("user"))?.profile;

    const [user, setUser] = useState({});

    useEffect(() => {
        setUser({ ...userInfo, password: user.password });
    }, []);

    const debouncedSearchQuery = useDebounce(search, 600);

    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    const handlerInputChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setUser({ ...user, [name]: value });
    };

    useEffect(async () => {
        setIsLoading(true);
        const { data } = await axios.get("/api/admin/product-category/", {
            params: {
                page: pagination.current,
                pageSize: pagination.pageSize,
                search: debouncedSearchQuery,
                start_date: startDate ? startDate : null,
                end_date: endDate ? endDate : null,
            },
        });
        setPagination({
            ...pagination,
            total: data.total,
        });
        setData(data.data);
        setIsLoading(false);
    }, [pagination.current, debouncedSearchQuery, startDate, endDate]);


    const handlerUpdateProfile = async () => {
        await axios.put("/api/admin/profile");
        message.success("Chỉnh sửa profile thành công");
    };


    return (
        <div>
            <Card
                className="mx-auto text-center position-relative pt-5 mt-5"
                style={{ width: 400 }}
            >
                <div>
                    <Avatar
                        className="custom-icon"
                        size={80}
                        style={{
                            backgroundImage: `url(${userInfo?.avatar})`,
                            backgroundPosition: "center",
                            border: "2px solid #fff",
                        }}
                    >
                        {userInfo?.name && userInfo?.name[0]?.toUpperCase()}
                    </Avatar>

                    <h4 className="mt-1">
                        {userInfo?.name ? userInfo?.name : "Mr Admin"}
                    </h4>
                    {/* <h4 className="mt-1">{"Mr Admin"}</h4> */}
                </div>
                <Form onFinish={handlerUpdateProfile}>
                    <Form.Item
                        name="name"
                        wrapperCol={{
                            offset: 0,
                            span: 24,
                        }}
                    >
                        <div>
                            <label
                                htmlFor={user.name}
                                className="floating-label"
                            >
                                Họ tên
                            </label>
                            <Input
                                name="name"
                                onChange={handlerInputChange}
                                value={user.name}
                            />
                        </div>
                    </Form.Item>
                    <Form.Item
                        name="address"
                        wrapperCol={{
                            offset: 0,
                            span: 24,
                        }}
                    >
                        <div>
                            <label
                                htmlFor={user.address}
                                className="floating-label"
                            >
                                Địa chỉ
                            </label>
                            <Input
                                name="address"
                                onChange={handlerInputChange}
                                value={user.address}
                            />
                        </div>
                    </Form.Item>
                    <Form.Item
                        name="email"
                        wrapperCol={{
                            offset: 0,
                            span: 24,
                        }}
                        // defaultValue={user.email}
                    >
                        <div>
                            <label htmlFor={"Email"} className="floating-label">
                                Email
                            </label>
                            <Input
                                name="email_verified_at"
                                onChange={handlerInputChange}
                                value={
                                    user.email_verified_at
                                        ? user.email_verified_at
                                        : "adminTest@gmail.com"
                                }
                            />
                        </div>
                    </Form.Item>
                    <Form.Item
                        name="facebook"
                        wrapperCol={{
                            offset: 0,
                            span: 24,
                        }}
                    >
                        <div>
                            <label
                                htmlFor={user.facebook}
                                className="floating-label"
                            >
                                Facebook
                            </label>
                            <Input
                                name="name"
                                onChange={"handlerInputChange"}
                                value={user.facebook}
                            />
                        </div>
                    </Form.Item>
                    <Form.Item
                        name="phone"
                        wrapperCol={{
                            offset: 0,
                            span: 24,
                        }}
                    >
                        <div>
                            <label
                                htmlFor={user.phone}
                                className="floating-label"
                            >
                                Số điện thoại
                            </label>
                            <Input
                                name="phone"
                                onChange={handlerInputChange}
                                value={user.phone}
                            />
                        </div>
                    </Form.Item>
                    <Form.Item
                        name="password"
                        wrapperCol={{
                            offset: 0,
                            span: 24,
                        }}
                    >
                        <label
                            htmlFor={"user.password"}
                            className="floating-label"
                        >
                            Mật khẩu
                        </label>
                        <Input.Password
                            name="password"
                            placeholder="*******"
                            value={"user.password"}
                        />
                    </Form.Item>
                    <div className="d-flex justify-content-start pt-3">
                        <Button htmlType="submit" type="primary">
                            Cập nhật
                        </Button>
                    </div>
                </Form>
            </Card>
        </div>
    );
};
export default ProfilePage;
