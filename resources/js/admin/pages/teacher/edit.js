import {
  message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';
import { useState } from "react";

const EditCustomerPage = () => {
  const navigate = useNavigate();
  const queryClient = useQueryClient();
  const { id } = useParams();
  const [content, setContent] = useState('')

  const { isLoading, data } = useQuery(['teacher', [id]], async () => {
      const { data } = await axios.get("/api/admin/teacher/" + id);
      return { ...data.profile, email: data.email, fullName: data.name };

  });

  const onFinish = async (values) => {
      try {
          values = { ...values}
          console.log(values ,'values');
          await axios.put("/api/admin/teacher/" + id, values);
          message.success("Sữa giảng viên thành công");
          queryClient.invalidateQueries("teacher");
          navigate("/admin/teacher");
      } catch ({ response }) {
        const { data } = response;
        const { error } = data;
        let errorMessage = "Error";

        for (const [key, value] of Object.entries(error)) {
            errorMessage = value;
        }
        message.error(errorMessage);
      }
  };

  return <div>
      <Breadcrumb items={["Giáo viên", "Chỉnh sửa"]} />
      <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
          <div className="d-flex justify-content-center" >
              <Skeleton active loading={isLoading}>
                  <Form
                      isEdit
                      initialValues={data}
                      onFinish={onFinish}
                      onChecked={(value) => setStatus(value)}
                      onEditor={(data) => setContent(data)}
                  />
              </Skeleton>
          </div>
      </div>
  </div>
}
export default EditCustomerPage;
