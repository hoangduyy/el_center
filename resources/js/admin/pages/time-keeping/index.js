const { Button, Table, Space, DatePicker, Input, Modal } = require("antd");

import { useNavigate } from "react-router";
import { useQueryClient, useQuery } from "react-query";
import { Link, useLocation } from "react-router-dom";
import React, { useEffect, useState, useCallback } from "react";
import { useDebounce } from "../../../lib/hook";

import moment from "moment";

const CustomerPage = () => {
  const navigate = useNavigate();
  const queryClient = useQueryClient();
  const [filter, setFilter] = useState({
    search: null,
    month: moment(),
  });

  const [data, setData] = useState([]);
  const [complains, setComplains] = useState([]);
  const [complainContent, setComplainContent] = useState(null);
  const [openComplain, setOpenComplain] = useState(null);


  const debouncedSearchQuery = useDebounce(filter, 600);

  const columns = [
    {
      title: "Nhân viên",
      dataIndex: "name",
      key: "name",
    },
    {
      title: 'Số phút đi muôn',
      key: "lt",
      render: (text, record) => {
        //sum time keeping compare
        return record.time_keepings?.filter(item => item.type == 1).reduce((acc, item) => {
          if (item.compare_time > 0) {
            return acc;
          }
          return acc + item.compare_time;
        }, 0);
      }
    },
    {
      title: 'Số phút về sớm',
      key: "gt",
      render: (text, record) => {
        //sum time keeping compare
        return record.time_keepings?.filter(item => item.type == 2).reduce((acc, item) => {
          if (item.compare_time > 0) {
            return acc;
          }
          return acc + item.compare_time;
        }, 0);
      }
    },
  ];

  useEffect(() => {
    axios.get("/api/admin/time-keeping", {
      params: {
        ...filter,
        start: moment(filter.month).startOf("month").format("YYYY-MM-DD"),
        end: moment(filter.month).endOf("month").format("YYYY-MM-DD"),
        search: debouncedSearchQuery,
      },
    }).then(({ data }) => {
      console.log(data)
      setData(data.data);
    });

    axios.get("/api/admin/time-keeping-complain", {
      params: {
        ...filter,
        start: moment(filter.month).startOf("month").format("YYYY-MM-DD"),
        end: moment(filter.month).endOf("month").format("YYYY-MM-DD"),
        search: debouncedSearchQuery,
      },
    }).then(({ data }) => {
      setComplains(data.data);
    });

  }, [filter.month, filter.search]);


  const expandedRowRender = (record) => {
    const groupsDate = record.time_keepings.reduce((groups, item) => {
      const date = moment(item).format("DD-MM-YYYY");
      const index = groups.findIndex(item => item.date === date);
      if (index < 0) {
        groups.push({
          date,
          data: [item],
        });
      } else {
        groups[index].data.push(item);
      }
      return groups;
    }, []);

    return <Table
      rowKey="id"
      expandable={{
        rowExpandable: false,
        showExpandColumn: false
      }}
      columns={[
        {
          title: 'Ngày', dataIndex: 'date', key: 'date',
        },
        {
          title: "Checkin",
          children: [
            {
              title: "Giờ Checkin",
              render: (text, record) => {
                const checkin = record.data.filter(x => x.type == 1);
                const created_at = checkin[checkin.length - 1]?.["created_at"];
                return created_at ? moment(created_at)?.format("HH:mm") : null
              },
            }, {
              title: "Đi muộn",
              render: (text, record) => {
                const checkin = record.data.filter(x => x.type == 1);
                const compare_time = checkin[checkin.length - 1]?.["compare_time"];
                return compare_time < 0 ? compare_time : null
              },
            }
          ]
        },
        {
          title: "Checkout",
          children: [
            {
              title: "Giờ Checkout",
              render: (text, record) => {
                const checkin = record.data.filter(x => x.type == 2);
                const created_at = checkin[checkin.length - 1]?.["created_at"];
                return created_at ? moment(created_at)?.format("HH:mm") : null
              },
            }, {
              title: "Về sớm",
              render: (text, record) => {
                const checkin = record.data.filter(x => x.type == 2);
                const compare_time = checkin[checkin.length - 1]?.["compare_time"];
                return compare_time < 0 ? compare_time : null
              },
            }
          ]
        },
        {
          title: "Khiếu nại",
          render: (text, record) => {
            const complain = complains.find(item => {
              console.log(item.date, moment(record.date, "DD-MM-YYYY").format("YYYY-MM-DD"))
              return item.date == record.date
            });
            return complain ? complain.complain : <Button onClick={() => setOpenComplain(record.date)}>Khiếu nại</Button>;
          }
        },
        {
          title: "Trả lời",
          render: (text, record) => {
            const complain = complains.find(item => {
              return item.date == record.date
            });
            return complain?.reply ? complain.reply : <Button onClick={() => setOpenComplain(record.date)}>Trả lời</Button>;
          }
        }
      ]}

      dataSource={groupsDate} pagination={false} />;
  };

  const sendCompain = async () => {
    try {
      const index = complains.findIndex(item => {
        return item.date == openComplain
      })
      if (index >= 0) {
        var { data } = await axios.put("/api/admin/time-keeping-complain/" + complains[index].id, {
          reply: complainContent,
        });
        setComplains([
          ...complains,
          data
        ]);

      } else {
        var { data } = await axios.post("/api/admin/time-keeping-complain", {
          date: openComplain,
          complain: complainContent,
        });
        complains[index] = data;
        setComplains([
          ...complains,
        ]);
      }

      setOpenComplain(null);

    } catch (e) {
      console.log(e)
    }
  };

  return (
    <div>
      <div
        className="site-layout-background"
        style={{ padding: 24, minHeight: 360, marginTop: 20 }}
      >

        <Space className="mb-5">
          <DatePicker size='default'
            value={filter.month}
            onChange={value => setFilter({
              ...filter,
              month: value
            })}
            picker="month" />
        </Space>

        <Table
          rowKey="id"
          columns={columns}
          expandable={{
            expandedRowRender,
          }}
          dataSource={data}
          bordered
          size="middle"
        />
      </div>

      <Modal visible={!!openComplain}
        title={`Khiếu nại`}
        onCancel={
          () => setOpenComplain(null)
        }
        onOk={() => sendCompain()}
      >
        <Input
          value={complainContent}
          onChange={v => setComplainContent(v.target.value)}
        />
      </Modal>

    </div>
  );
};
export default CustomerPage;


