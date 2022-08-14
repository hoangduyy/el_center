import {
    Layout,
    Menu,
    Avatar,
    Dropdown,
    Space,
    Button,
    Popconfirm,
} from "antd";
const { Header, Content, Footer, Sider } = Layout;
const { SubMenu } = Menu;
import routes from "../routes";
import { useNavigate } from "react-router";
import { Link } from "react-router-dom";
import React, { useEffect, useState, useContext } from "react";
import MenuContext from "../context/menu";
import { useMatch } from "react-router-dom";
import { useQueryClient, useQuery } from "react-query";

const DashBoard = ({ children }) => {
    const { collapsed, toggleMenu } = useContext(MenuContext);
    const role = JSON.parse(localStorage.getItem("user"))?.role;
    const queryClient = useQueryClient();
    const userInfo = localStorage.getItem("user") ? JSON.parse(localStorage.getItem("user")) :  {};


    // console.log(path);
    const navigate = useNavigate();
    useEffect(() => {
        const token = localStorage.getItem("access_token");
        if (!token) {
            navigate("/admin/login");
        }
    }, []);

    const handleCheckInOut = async (type) => {
        try {
            await axios.post("/api/admin/time-keeping", {
                type,
            });

            message.success(
                type == 1 ? "Checkout thành công" : "Check in thành công"
            );
            queryClient.invalidateQueries("time-keeping");
        } catch ({ response }) {}
    };

    let selectedKey = null;
    let openKey = null;
    routes
        .filter((x) => !x.hidden)
        .map((x, index) => {
            if (!x.childs) {
                const path = useMatch({
                    path: "admin/" + x.path,
                    end: true,
                });
                if (!!path) {
                    selectedKey = "" + index;
                    openKey = null;
                }
            } else {
                x.childs
                    .filter((x) => !x.hidden)
                    .map((c, cIndex) => {
                        const path = useMatch({
                            path: "admin/" + x.path + "/" + c.path,
                            end: true,
                        });
                        if (!!path) {
                            openKey = "" + index;
                            selectedKey = index + "-" + cIndex;
                        }
                    });
            }
        });
    const handleLogout = () => {
        localStorage.removeItem("access_token");
        navigate("/admin/login");
    };

    const menu = (
        <Menu style={{ width: 220 }}>
            <Menu.Item key="0">
                <Link to="/admin/profile">Hồ sơ</Link>
            </Menu.Item>
            <Menu.Divider />
            <Menu.Item key="3" onClick={handleLogout}>
                Đăng xuất
            </Menu.Item>
        </Menu>
    );

    return (
        <Layout style={{ minHeight: "100vh" }}>
            <Sider
                collapsible
                collapsed={collapsed}
                onCollapse={(state) => toggleMenu()}
            >
                <div className="logo">
                    <h2 style={{ color: "white" }}>
                        <Link to="/admin/dashboard">ELCenter</Link>
                    </h2>
                    {/* <img src={
                        collapsed ? "/images/logo-mini.png" : "/images/logo.png"
                    } /> */}
                </div>
                <Menu
                    theme="dark"
                    defaultSelectedKeys={[selectedKey]}
                    defaultOpenKeys={[openKey]}
                    mode="inline"
                >
                    {routes
                        .filter((x) => !x.hidden && x.roles?.includes(role))
                        .map((r, index) => {
                            const childs = r.childs?.filter((x) => !x.hidden);

                            if (childs) {
                                return (
                                    <SubMenu
                                        key={index}
                                        icon={r.icon}
                                        title={r.title}
                                    >
                                        {childs.map((c, cIndex) => (
                                            <Menu.Item
                                                key={index + "-" + cIndex}
                                            >
                                                <Link
                                                    to={r.path + "/" + c.path}
                                                >
                                                    {c.title}
                                                </Link>
                                            </Menu.Item>
                                        ))}
                                    </SubMenu>
                                );
                            } else {
                                return (
                                    <Menu.Item
                                        key={index}
                                        title={r.title}
                                        icon={r.icon}
                                    >
                                        <Link to={r.path}>{r.title}</Link>
                                    </Menu.Item>
                                );
                            }
                        })}
                </Menu>
            </Sider>
            <Layout className="site-layout">
                <Header
                    className="site-layout-background"
                    style={{ padding: 0 }}
                >
                    <Space
                        style={{
                            float: "right",
                        }}
                    >
                        <Popconfirm
                            title="Check in"
                            onConfirm={() => handleCheckInOut(1)}
                        >
                            <Button>
                                Check In
                            </Button>
                        </Popconfirm>
                        <Popconfirm
                            title="Check out"
                            onConfirm={() => handleCheckInOut(2)}
                        >
                            <Button>
                                Check out
                            </Button>
                        </Popconfirm>
                  
                        <Dropdown overlay={menu} trigger={["click"]}>
                            <Avatar
                                className="custom-icon mr-3"
                                style={{
                                    backgroundColor: "#ff7979",
                                    fontWeight: 500,
                                    cursor: "pointer",
                                }}
                            >
                                {userInfo?.profile?.name[0]}
                            </Avatar>
                        </Dropdown>
                    </Space>
                </Header>
                <Content style={{ margin: "0 16px" }}>{children}</Content>
                <Footer style={{ textAlign: "center" }}>
                    Shop Created by Blacker
                </Footer>
            </Layout>
        </Layout>
    );
};
export default DashBoard;
