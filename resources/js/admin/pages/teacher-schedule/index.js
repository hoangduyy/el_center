const {
    Button,
    Table,
    Popconfirm,
    message,
    Input,
    Space,
    Tooltip,
} = require("antd");
import { DeleteFilled, EditFilled, CopyOutlined } from "@ant-design/icons";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient, useQuery } from "react-query";
import { Link, useLocation } from "react-router-dom";
import { css } from "@emotion/react";
import { useEffect, useState } from "react";
import { useDebounce } from "../../../lib/hook";
import moment from "moment";
import Calendar from "../../components/calendar";

import FullCalendar from "@fullcalendar/react";
import dayGridPlugin from "@fullcalendar/daygrid";

const TeacherSchedule = () => {
    const [events, setEvents] = useState([]);

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/teacher/schedule");
        const temp = [];
        data.schedules.forEach((item) => {
            item.schedule.details.forEach((d) => {
                temp.push({
                    class: item.title,
                    id: d.id,
                    start_date: d.start_date,
                    end_date: d.end_date,
                    note: d.note,
                    date: d.start_date,
                    title:
                        item.schedule.start_hour.substring(
                            0,
                            item.schedule.start_hour.length - 3
                        ) +
                        " - " +
                        item.schedule.end_hour.substring(
                            0,
                            item.schedule.end_hour.length - 3
                        ) +
                        " / " +
                        item.title,
                });
            });
        });

        setEvents(temp);

        console.log(temp, "temp");
    }, []);

    let x = [
        {
            id: 6,
            title: "HOM NAY",
            date: new Date(),
        },
        {
            id: 9,
            title: "HOM 2",
            date: new Date(),
        },
    ];

    const handleEventClick = ({ event }) => {
        // openAppointment is a function I wrote to open a form to edit that appointment
        // this.props.openAppointment(event.extendedProps);
        console.log("handleEventClick", event);
        console.log(event._def.title, "title");
    };

    const handleEventDrop = (info) => {
        if (window.confirm("Are you sure you want to change the event date?")) {
            console.log("change confirmed");

            // updateAppointment is another custom method
            this.props.updateAppointment({
                ...info.event.extendedProps,
                start: info.event.start,
                end: info.event.end,
            });
        } else {
            console.log("change aborted");
        }
    };

    return (
        <div>
            <Breadcrumb items={["Thời khoá biểu"]}>
                <Space>
                    <Calendar
                        name="startDate"
                        onChange={(date) => setStartDate(date)}
                        placeholder="Start date"
                    />
                    <Calendar
                        name="endDate"
                        onChange={(date) => setEndDate(date)}
                        placeholder="End date"
                    />
                </Space>
            </Breadcrumb>
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <FullCalendar
                    defaultView="dayGridMonth"
                    plugins={[dayGridPlugin]}
                    eventMouseEnter={
                        (arg) => {
                            // <Tooltip id="registerTip" place="top" effect="solid">
                            //     {arg.event.title}
                            // </Tooltip>
                            // // alert(arg.event.title);
                        }
                    }
                    eventDidMount={(info) => {
                        <Tooltip placement="top" title={"123"}>
                            <Button>Top</Button>
                        </Tooltip>;
                    }}
                    events={events}
                    displayEventTime={false}
                    editable={true}
                    eventDrop={handleEventDrop}
                    eventClick={handleEventClick}
                />
            </div>
        </div>
    );
};

export default TeacherSchedule;
