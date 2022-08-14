import { css } from "@emotion/react";
import React, { useEffect, useState } from "react";
import { useQuery } from "react-query";
import "../../../../css/app.css";
import {
    DatePicker,
    TimePicker,
    Select,
    Button,
    Form,
    Card,
    Table,
} from "antd";
import { ArrowRightOutlined } from "@ant-design/icons";
import moment from "moment";

const ClassScheduleForm = ({
    onFinish,
    isEdit,
    success,
    onChangeStartDate,
    onChangeEndDate,
    onChangeDay,
    ...props
}) => {
    const [form] = Form.useForm();
    const [classes, setClasses] = useState([]);
    const [teachers, setTeachers] = useState([]);
    const [rooms, setRooms] = useState([]);
    const [ableRoom, setAbleRoom] = useState(false);

    const [days, setDays] = useState([
        { name: "Thứ 2", value: 2, status: false },
        { name: "Thứ 3", value: 3, status: false },
        { name: "Thứ 4", value: 4, status: false },
        { name: "Thứ 5", value: 5, status: false },
        { name: "Thứ 6", value: 6, status: true },
        { name: "Thứ 7", value: 7, status: true },
        { name: "Chủ nhật", value: 8, status: true },
    ]);

    const [startHour, setStartHour] = useState(null);
    const [endHour, setEndHour] = useState(null);

    const { isLoading, data } = useQuery(["class-schedule"], async () => {
        const { data } = await axios.get("/api/admin/class-schedule");
        return data;
    });

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/class");
        setClasses(data.data);
    }, []);

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/teacher");
        setTeachers(data.data);
    }, []);

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/room/schedule");
        setRooms(data.data);
    }, []);

    useEffect(async () => {
        if (startHour == null || endHour == null) {
            setAbleRoom(false);
            return;
        }
        if (days.filter((item) => item.status).length === 0) {
            setAbleRoom(false);
            return;
        }

        let dates = days.filter((item) => item.status).map((item) => item.value);
        let paramQuery = "";
        dates.forEach((date,index) => {
            paramQuery += `&days[${index}]=${date}`;
        });

        const { data } = await axios.get(`/api/admin/room/schedule?startHour=${moment(startHour).format("hh:mm")}&endHour=${moment(endHour).format("hh:mm")}${paramQuery}`);
        setRooms(data.data);
        setAbleRoom(true);
    }, [days, startHour, endHour]);

    const handleOnFinish = (data) => {
        const formatStartDate = startHour.format("HH:mm:ss");
        const formatEndDate = endHour.format("HH:mm:ss");
        onFinish({
            ...data,
            startHour: formatStartDate,
            endHour: formatEndDate,
            days: days.filter((item) => item.status).map((item) => item.value),
        });
    };

    const handleClickDay = (value) => {
        let dates = [...days];
        let index = dates.findIndex((item) => item.value === value);
        dates[index].status = !dates[index].status;
        setDays(dates);
    };



    return (
        <Form
            labelCol={{
                span: 6,
            }}
            form={form}
            onFinish={handleOnFinish}
            scrollToFirstError
            {...props}
        >
            <Form.Item
                name="class_id"
                label="Chọn lớp"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập lớp học",
                    },
                ]}
            >
                <Select
                    showSearch
                    allowClear
                    filterOption={(inputValue, option) =>
                        option.props.children
                            .toString()
                            .toLowerCase()
                            .includes(inputValue.toLowerCase())
                    }
                    style={{ width: "100%" }}
                    placeholder="Chọn lớp"
                >
                    {classes.map((item) => (
                        <Option key={item.id} value={item.id}>
                            {item.title +
                                " ( " +
                                moment(item.start_date).format("DD/MM/YYYY") +
                                " - " +
                                moment(item.end_date).format("DD/MM/YYYY") +
                                ")"}
                        </Option>
                    ))}
                </Select>
            </Form.Item>

            <Form.Item
                name="teacher_id"
                label="Chọn giáo viên"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập lớp học",
                    },
                ]}
            >
                <Select
                    showSearch
                    allowClear
                    filterOption={(inputValue, option) =>
                        option.props.children
                            .toString()
                            .toLowerCase()
                            .includes(inputValue.toLowerCase())
                    }
                    style={{ width: "100%" }}
                    placeholder="Chọn giáo viên"
                >
                    {teachers.map((item) => (
                        <Option key={item.id} value={item.id}>
                            {item.name}
                        </Option>
                    ))}
                </Select>
            </Form.Item>

            <Form.Item
                label="Thời gian"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng chọn thời gian",
                    },
                ]}
            >
                <div>
                    {[1].map((item, index) => {
                        return (
                            <div className="schedule_time">
                                <div>
                                    <TimePicker
                                        placeholder="Chọn thời gian"
                                        onChange={setStartHour}
                                    />
                                </div>
                                <div className="mx-4">
                                    <ArrowRightOutlined
                                        style={{ color: "#096dd9" }}
                                    />
                                </div>
                                <div>
                                    <TimePicker
                                        placeholder="Chọn thời gian"
                                        onChange={setEndHour}
                                    />
                                </div>
                            </div>
                        );
                    })}
                </div>
            </Form.Item>

            <Form.Item
                label="Chọn ngày"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng chọn thời gian",
                    },
                ]}
            >
                {days.map((item) => (
                    <span
                        onClick={() => {
                            handleClickDay(item.value);
                        }}
                        className={
                            item.status === true
                                ? "schedule-pick-day active_day"
                                : "schedule-pick-day"
                        }
                    >
                        {" "}
                        {item.name}{" "}
                    </span>
                ))}
            </Form.Item>

            <Form.Item
                name="room_id"
                label="Chọn phòng"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập lớp học",
                    },
                ]}
            >
                <Select
                    showSearch
                    allowClear
                    filterOption={(inputValue, option) =>
                        option.props.children
                            .toString()
                            .toLowerCase()
                            .includes(inputValue.toLowerCase())
                    }
                    style={{ width: "100%" }}
                    placeholder="Chọn phòng"
                    disabled={!ableRoom}
                >
                    {rooms.map((item) => (
                        <Option key={item.id} value={item.id}>
                            {item.name}
                        </Option>
                    ))}
                </Select>
            </Form.Item>

            <Form.Item className="float-right">
                <Button disabled={success} type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default ClassScheduleForm;
