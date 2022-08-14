import { css } from '@emotion/react';
import {
    QueryClient,
    QueryClientProvider,
} from 'react-query'

import {
    BrowserRouter,
    Routes,
    Route,
    Outlet
} from "react-router-dom";
import React, { Suspense } from 'react';
const queryClient = new QueryClient()
import LoginPage from './pages/login';
import DashBoard from './pages';
import routes from './routes';
import { Spin } from 'antd';
import { MenuProvider } from './context/menu';

const App = () => {
    const role = JSON.parse(localStorage.getItem('user'))?.role;
    return (
        <QueryClientProvider client={queryClient}>
            <Suspense fallback={<Spin />}>
                <MenuProvider>
                    <BrowserRouter>
                        <Routes>
                            <Route path="/admin/login" element={<LoginPage />} />
                            <Route path="/admin" element={<DashBoard><Outlet /></DashBoard>}>
                                {
                                    routes
                                        .map(({roles, path, component: Comp, childs }) => {

                                            if(roles?.includes(role)){
                                                return childs ? childs.map(({ path: childPath, component: ChildComp }) => <Route
                                                    path={path + "/" + childPath}
                                                    element={<ChildComp />}
                                                />
                                                ) : <Route
                                                    path={path}
                                                    key={path}
                                                    element={<Comp />}
                                                />
                                            }
                                        }
                                        )}
                                <Route index />
                            </Route>
                        </Routes>
                    </BrowserRouter>
                </MenuProvider>
            </Suspense>
        </QueryClientProvider >
    );
};

export default App;
