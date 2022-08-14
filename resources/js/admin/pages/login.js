import { Form, Input, Button, Checkbox, Card, message } from 'antd';
import { css } from '@emotion/react';
import axios from 'axios';
import { useNavigate } from 'react-router';
import { useEffect } from 'react';

const LoginPage = () => {
    let navigate = useNavigate();
    useEffect(() => {
        if (localStorage.getItem("access_token")) {
            navigate("/admin");
        }
    }, [])
    const onFinish = async (values) => {
        try {
            await axios.get('/sanctum/csrf-cookie');
            var { data } = await axios.post("/api/admin/login", values);
            localStorage.setItem("access_token", data.access_token);
            localStorage.setItem("user", JSON.stringify(data.user));
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token;
            navigate("/admin/dashboard");

        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };


    return (
        <div
            css={css`
            background-image:url("/images/admin-bg.png");
            height:100vh;
            background-position:left bottom;
            background-size:cover;
            `}
        >
            <Card
                css={css`
                    width:400px;
                    position:fixed;
                    top:50%;
                    left:50%;
                    transform:translate(-50%,-50%);
                    border-radius:10px;
                `}
            >
                <h1>Đăng nhập</h1>
                <Form
                    name="basic"
                    labelCol={{
                        span: 8,
                    }}
                    wrapperCol={{
                        span: 16,
                    }}
                    initialValues={{
                        remember: true,
                    }}
                    onFinish={async (values) => await onFinish(values)}
                >
                    <Form.Item
                        label="Email"
                        name="email"
                        rules={[
                            {
                                type: "email",
                                message: "Email không đúng định dạng"
                            },
                            {
                                required: true,
                                message: 'vui lòng nhập tài khoản',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        label="Mật khẩu"
                        name="password"
                        rules={[
                            {
                                required: true,
                                message: 'vui lòng nhập mật khẩu',
                            },
                        ]}
                    >
                        <Input.Password />
                    </Form.Item>

                    <Form.Item
                        name="remember"
                        valuePropName="checked"
                        wrapperCol={{
                            offset: 8,
                            span: 16,
                        }}
                    >
                        <Checkbox>Ghi nhớ</Checkbox>
                    </Form.Item>

                    <Form.Item
                        wrapperCol={{
                            offset: 8,
                            span: 16,
                        }}
                    >
                        <Button type="primary" htmlType="submit">
                            Đăng nhập
                        </Button>
                    </Form.Item>
                </Form>
            </Card>

        </div>
    );
};
export default LoginPage;
