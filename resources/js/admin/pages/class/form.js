import { css } from "@emotion/react";
import {
    Form,
    Input,
    Button,
    Upload,
    Progress,
    Image,
    Switch,
    InputNumber,
    Select,
    DatePicker,
} from "antd";
import React, { useEffect, useState } from "react";
import { InboxOutlined } from "@ant-design/icons";
import moment from "moment";

const { TextArea } = Input;
const { Option } = Select;
const listOption = ["Điều hoà", "Wifi", "Giáo viên nước ngoài"];
const children = [];
for (let i = 0; i < listOption.length; i++) {
    children.push(<Option key={i}>{listOption[i]}</Option>);
}

const dateFormat = "YYYY-MM-DD hh:mm:ii";
const ClassForm = ({
    onFinish,
    isEdit,
    onChecked,
    onChangeStartDate,
    onChangeEndDate,
    onChangeQty,
    ...props
}) => {
    const [form] = Form.useForm();
    const [courses, setCourses] = useState([]);
    const [rooms, setRooms] = useState([]);

    const handleOnFinish = (value) => {
        onFinish(value);
    };

    const [defaultFileList, setDefaultFileList] = useState(
        props.initialValues
            ? [
                  {
                      id: -1,
                      status: "done",
                      url: props.initialValues.thumbnail,
                  },
              ]
            : []
    );

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/course");
        setCourses(data.data);
    }, []);

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/room");
        setRooms(data.data);
    }, []);

    const [progress, setProgress] = useState(0);

    const uploadImage = async (options) => {
        const { onSuccess, onError, file, onProgress } = options;

        const fmData = new FormData();
        const config = {
            headers: { "content-type": "multipart/form-data" },
            onUploadProgress: (event) => {
                const percent = Math.floor((event.loaded / event.total) * 100);
                setProgress(percent);
                if (percent === 100) {
                    setTimeout(() => setProgress(0), 1000);
                }
                onProgress({ percent: (event.loaded / event.total) * 100 });
            },
        };
        fmData.append("file", file);
        try {
            const res = await axios.post("/api/admin/upload", fmData, config);
            return onSuccess(res.data.file);
        } catch (err) {
            console.log("Eroor: ", err);
            const error = new Error("Some error");
            onError({ err });
        }
    };

    const handleOnChange = ({ file, fileList, event }) => {
        if (file.status == "done") {
            setDefaultFileList([
                {
                    id: file.uid,
                    status: "done",
                    url: file.response,
                },
            ]);
        }
    };

    const handleChecked = (checked) => {
        setIsActive(checked);
        onChecked(checked);
    };

    const handleChangeQty = (data) => {
        onChangeQty(data);
    };

    const handleChangeStartDate = (data) => {
        console.log(data, "data");
        onChangeStartDate(data);
    };

    const handleChangeEndDate = (data) => {
        console.log(data, "data");
        onChangeEndDate(data);
    };

    return (
        <Form
            css={css`
                width: 600px;
            `}
            labelCol={{
                span: 6,
            }}
            form={form}
            onFinish={handleOnFinish}
            scrollToFirstError
            {...props}
        >
            <Form.Item
                name="title"
                label="Tên lớp học"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tiêu đề",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="code"
                label="Mã lớp học"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập mã lớp học",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item label="Ảnh đại diện">
                {defaultFileList.length > 0 && (
                    <Image src={defaultFileList[0].url} />
                )}
                <Form.Item
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng tải ảnh đại diện cho lớp học",
                        },
                    ]}
                    name="thumbnail"
                    valuePropName="file"
                    getValueFromEvent={(e) => e && e.file.response}
                    noStyle
                >
                    <Upload.Dragger
                        name="file"
                        accept="image/*"
                        multiple={false}
                        customRequest={uploadImage}
                        onChange={handleOnChange}
                        listType="picture-card"
                        defaultFileList={defaultFileList}
                        className="image-upload-grid"
                        showUploadList={false}
                    >
                        <div>
                            <p className="ant-upload-drag-icon">
                                <InboxOutlined />
                            </p>
                            <p className="ant-upload-text">
                                Kéo ảnh vào để tải ảnh lên
                            </p>
                        </div>
                        {progress > 0 ? <Progress percent={progress} /> : null}
                    </Upload.Dragger>
                </Form.Item>
            </Form.Item>
            <Form.Item name="note" label="Ghi chú">
                <TextArea row={6} />
            </Form.Item>

            <Form.Item
                label="Số học viên"
                // rules={[
                //     {
                //         required: true,
                //         message: "Vui lòng nhập số học viên",
                //     },
                // ]}
            >
                <InputNumber
                    defaultValue={
                        props.initialValues ? props.initialValues.qty : ""
                    }
                    onChange={handleChangeQty}
                />
                <span> học viên</span>
            </Form.Item>

            <Form.Item
                label="Ngày bắt đầu"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập ngày bắt đầu",
                    },
                ]}
            >
                <DatePicker
                    defaultValue={
                        props.initialValues
                            ? moment(
                                  new Date(props.initialValues.start_date),
                                  "DD/MM/YYYY"
                              )
                            : ""
                    }
                    onChange={handleChangeStartDate}
                />
            </Form.Item>

            <Form.Item
                label="Ngày kết thúc"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng chọn ngày kết thúc",
                    },
                ]}
            >
                <DatePicker
                    defaultValue={
                        props.initialValues
                            ? moment(
                                  new Date(props.initialValues.end_date),
                                  "DD/MM/YYYY"
                              )
                            : ""
                    }
                    onChange={handleChangeEndDate}
                />
            </Form.Item>
            <Form.Item
                name="course_id"
                label="Khoá học"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng chọn khoá học",
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
                    defaultValue={
                        props.initialValues
                            ? props.initialValues?.course_id
                            : ""
                    }
                >
                    {courses.map((item) => (
                        <Select.Option value={item.id} key={item.id}>
                            {item.title}
                        </Select.Option>
                    ))}
                </Select>
            </Form.Item>

            <Form.Item name="room_id" label="Phòng học">
                <Select
                    showSearch
                    allowClear
                    filterOption={(inputValue, option) =>
                        option.props.children
                            .toString()
                            .toLowerCase()
                            .includes(inputValue.toLowerCase())
                    }
                    defaultValue={
                        props.initialValues ? props.initialValues?.room_id : ""
                    }
                >
                    {rooms.map((item) => (
                        <Select.Option value={item.id} key={item.id}>
                            {item.name}
                        </Select.Option>
                    ))}
                </Select>
            </Form.Item>

            <Form.Item name="status" label="Trạng thái" valuePropName="checked">
                <Switch
                    defaultChecked={
                        props.initialValues === 1
                            ? props.initialValues?.status
                            : true
                    }
                    onChange={(checked) => handleChecked(checked)}
                />
            </Form.Item>

            <Form.Item className="float-right">
                <Button type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default ClassForm;
