<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="NewAccount.aspx.cs" Inherits="AccountingJournal.ManageAccount.NewAccount" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group text-center">
            <div class="panel-heading">
                Accounts
            </div>
            <div class="panel-body">
                <div class="container">
                    <div class="panel panel-primary form-group text-center">
                        <div class="panel-heading">
                            Create New Account
                        </div>
                        <div class="panel-body">
                            <table class="container" style="width: 100%">
                                <tr>
                                    <td style="width: 150px">
                                        <div class="text-left">Account #:</div>
                                        <div>
                                            <asp:TextBox ID="AccountNumber" runat="server" CssClass="form-control"></asp:TextBox>
                                            <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ErrorMessage="*" ForeColor="Red" ControlToValidate="AccountNumber"></asp:RequiredFieldValidator>
                                        </div>
                                    </td>
                                    <td style="width: 250px">
                                        <div class="text-left">Account Name:</div>
                                        <div>
                                            <asp:TextBox ID="Acc_Name" runat="server" CssClass="form-control"></asp:TextBox>
                                            <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" ErrorMessage="*" ForeColor="Red" ControlToValidate="Acc_Name"></asp:RequiredFieldValidator>
                                        </div>
                                    </td>
                                    <td style="width: 350px">
                                        <div class="text-left">Description:</div>
                                        <div>
                                            <asp:TextBox ID="Description" runat="server" CssClass="form-control"></asp:TextBox>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text-left">Normal Balance:</div>
                                        <div>
                                            <asp:DropDownList ID="NorBal" runat="server" CssClass="form-control">
                                                <asp:ListItem Value="1">Debit</asp:ListItem>
                                                <asp:ListItem Value="0">Credit</asp:ListItem>
                                            </asp:DropDownList>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-left">Account Type:</div>
                                        <div>
                                            <asp:DropDownList ID="Acc_Type" runat="server" DataSourceID="SqlDataSource4" CssClass="form-control" DataTextField="Type" DataValueField="TypeID"></asp:DropDownList>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-left">Class:</div>
                                        <div>
                                            <asp:DropDownList ID="Acc_Class" runat="server" DataSourceID="SqlDataSource5" CssClass="form-control" DataTextField="Class" DataValueField="ClassID"></asp:DropDownList>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <asp:Button ID="Create" runat="server" Text="Create" CssClass="btn btn-primary" OnClick="Create_Click" Width="100px" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="panel panel-primary form-group text-center">
                    <div class="panel-heading">
                        Edit Account
                    </div>
                    <div class="panel-body">
                        <table class="table" style="margin-bottom:0">
                            <tr>
                                <th class="text-center" style="width: 100px">Account #</th>
                                <th class="text-left" style="width: 300px">Name</th>
                                <th class="text-right" style="width: 90px">Balance</th>
                                <th class="text-center" style="width: 100px">Normal Balance</th>
                                <th class="text-left" style="width: 200px">Class</th>
                                <th class="text-center" style="width: 100px">Type</th>
                                <th class="text-center">Manage</th>
                            </tr>
                        </table>
                        <div style="width: 100%; height: 500px; overflow: auto;">
                            <asp:GridView ID="AllAccount" runat="server"
                                AutoGenerateColumns="False" DataSourceID="SqlDataSource1"
                                DataKeyNames="AccountID" CssClass="table" CellPadding="4" ForeColor="#333333" GridLines="None" ShowHeader="false">
                                <AlternatingRowStyle BackColor="White" />
                                <Columns>
                                    <asp:TemplateField HeaderText="Account #" SortExpression="AccNumber" ItemStyle-Width="100px" HeaderStyle-Width="100px">
                                        <EditItemTemplate>
                                            <asp:TextBox ID="Label6" runat="server" Text='<%# Bind("AccNumber") %>' CssClass="form-control text-center"></asp:TextBox>
                                        </EditItemTemplate>
                                        <ItemTemplate>
                                            <asp:Label ID="Label6" runat="server" Text='<%# Bind("AccNumber") %>' CssClass="text-center"></asp:Label>
                                        </ItemTemplate>
                                        <HeaderStyle CssClass="text-center" />
                                        <ItemStyle Width="100px"></ItemStyle>
                                    </asp:TemplateField>
                                    <asp:TemplateField HeaderText="Name" SortExpression="Name" ItemStyle-HorizontalAlign="Left" ItemStyle-Width="200px" HeaderStyle-Width="300px">
                                        <EditItemTemplate>
                                            <asp:TextBox ID="TextBox4" runat="server" Text='<%# Bind("Name") %>' CssClass="form-control"></asp:TextBox>
                                        </EditItemTemplate>
                                        <ItemTemplate>
                                            <asp:Label ID="Label5" runat="server" Text='<%# Bind("Name") %>'></asp:Label>
                                        </ItemTemplate>

                                        <ItemStyle HorizontalAlign="Left" Width="200px"></ItemStyle>
                                    </asp:TemplateField>
                                    <asp:TemplateField HeaderText="Balance" SortExpression="Balance" HeaderStyle-Width="90px">
                                        <EditItemTemplate>
                                            <%--<asp:TextBox ID="TextBox3" runat="server" Text='<%# Bind("Balance") %>' CssClass="form-control"></asp:TextBox> DataFormatString="{0:#,##0.00}"--%>
                                            <asp:Label ID="Label4" runat="server" Text='<%# Bind("Balance", "{0:#,##0.00}") %>' ForeColor="White"></asp:Label>
                                        </EditItemTemplate>
                                        <ItemTemplate>
                                            <asp:Label ID="Label4" runat="server" Text='<%# Bind("Balance", "{0:#,##0.00}") %>'></asp:Label>
                                        </ItemTemplate>
                                        <HeaderStyle CssClass="text-right" />
                                        <ItemStyle HorizontalAlign="Right"></ItemStyle>
                                    </asp:TemplateField>
                                    <asp:TemplateField HeaderText="Normal Balance" SortExpression="NormalBalance" HeaderStyle-HorizontalAlign="Center" ItemStyle-HorizontalAlign="Center" ItemStyle-Width="100px" HeaderStyle-Width="100px">
                                        <EditItemTemplate>
                                            <%--<asp:Label ID="Label1" runat="server" Text='<%# Eval("NormalBalance") %>'></asp:Label>--%>
                                            <asp:DropDownList ID="Label1" runat="server" DataValueField='<%# Eval("NormalBalance") %>' CssClass="form-control">
                                                <asp:ListItem>Debit</asp:ListItem>
                                                <asp:ListItem>Credit</asp:ListItem>
                                            </asp:DropDownList>
                                        </EditItemTemplate>
                                        <ItemTemplate>
                                            <asp:Label ID="Label3" runat="server" Text='<%# Bind("NormalBalance") %>' CssClass="text-center"></asp:Label>
                                        </ItemTemplate>
                                        <HeaderStyle CssClass="text-center" />
                                        <ItemStyle HorizontalAlign="Center" Width="100px"></ItemStyle>
                                    </asp:TemplateField>
                                    <asp:TemplateField HeaderText="Class" SortExpression="Class" HeaderStyle-HorizontalAlign="Center" ItemStyle-HorizontalAlign="Left" ItemStyle-Width="200px" HeaderStyle-Width="200px">
                                        <EditItemTemplate>
                                            <%--<asp:TextBox ID="TextBox2" runat="server" Text='<%# Bind("Class") %>'></asp:TextBox>--%>
                                            <asp:DropDownList ID="TextBox2" runat="server" DataSourceID="SqlDataSource3" DataTextField="Class" DataValueField="Class" CssClass="form-control" SelectedValue='<%# Bind("Class") %>'></asp:DropDownList>
                                        </EditItemTemplate>
                                        <ItemTemplate>
                                            <asp:Label ID="Label2" runat="server" Text='<%# Bind("Class") %>'></asp:Label>
                                        </ItemTemplate>

                                        <HeaderStyle HorizontalAlign="Center"></HeaderStyle>

                                        <ItemStyle HorizontalAlign="Left" Width="200px"></ItemStyle>
                                    </asp:TemplateField>
                                    <asp:TemplateField HeaderText="Type" SortExpression="Type" ItemStyle-HorizontalAlign="Center" HeaderStyle-Width="100px">
                                        <EditItemTemplate>
                                            <%--<asp:TextBox ID="TextBox1" runat="server" Text='<%# Bind("Type") %>'></asp:TextBox>--%>
                                            <asp:DropDownList ID="TextBox1" runat="server" DataSourceID="SqlDataSource2" DataTextField="Type" DataValueField="Type" CssClass="form-control" SelectedValue='<%# Bind("Type") %>'></asp:DropDownList>
                                        </EditItemTemplate>
                                        <ItemTemplate>
                                            <asp:Label ID="Label1" runat="server" Text='<%# Bind("Type") %>'></asp:Label>
                                        </ItemTemplate>
                                        <HeaderStyle CssClass="text-center" />
                                        <ItemStyle HorizontalAlign="Center" Width="100px"></ItemStyle>
                                    </asp:TemplateField>
                                    <asp:TemplateField ShowHeader="False" HeaderText="Manage">
                                        <EditItemTemplate>
                                            <asp:Button ID="LinkButton1" runat="server" CausesValidation="True" CommandName="Update" Text="Update" CssClass="btn btn-primary"></asp:Button>
                                            <asp:Button ID="LinkButton2" runat="server" CausesValidation="False" CommandName="Cancel" Text="Cancel" CssClass="btn btn-default"></asp:Button>
                                        </EditItemTemplate>
                                        <ItemTemplate>
                                            <asp:Button ID="LinkButton1" runat="server" CausesValidation="False" CommandName="Edit" Text="Edit" CssClass="btn btn-success"></asp:Button>
                                        </ItemTemplate>
                                        <HeaderStyle CssClass="text-center" Width="140px" />
                                    </asp:TemplateField>
                                </Columns>
                                <EditRowStyle BackColor="#2461BF" />
                                <FooterStyle BackColor="#507CD1" Font-Bold="True" ForeColor="White" />
                                <HeaderStyle BackColor="#507CD1" Font-Bold="True" ForeColor="White" />
                                <PagerStyle BackColor="#2461BF" ForeColor="White" HorizontalAlign="Center" />
                                <RowStyle BackColor="#EFF3FB" />
                                <SelectedRowStyle BackColor="#D1DDF1" Font-Bold="True" ForeColor="#333333" />
                                <SortedAscendingCellStyle BackColor="#F5F7FB" />
                                <SortedAscendingHeaderStyle BackColor="#6D95E1" />
                                <SortedDescendingCellStyle BackColor="#E9EBEF" />
                                <SortedDescendingHeaderStyle BackColor="#4870BE" />
                            </asp:GridView>
                        </div>
                        <asp:SqlDataSource ID="SqlDataSource1" runat="server" ConnectionString="<%$ ConnectionStrings:TransactionDB %>" DeleteCommand="DELETE FROM [Account] WHERE [AccountID] = @AccountID" InsertCommand="INSERT INTO [Account] ([AccNumber], [Name], [Desc], [IsActive], [AccTypeID], [IsDebit], [AccClassID], [SortOrder], [Cre_Date], [Cre_User], [Balance]) VALUES (@AccNumber, @Name, @Desc, @IsActive, @AccTypeID, @IsDebit, @AccClassID, @SortOrder, @Cre_Date, @Cre_User, @Balance)" SelectCommand="SELECT 
AccountID, AccNumber, a.Name, Balance , case when IsDebit = 1 then 'Debit' else 'Credit' end as NormalBalance,
ac.Class
, at.Type 
FROM [Account] a
inner join AccClass ac on a.AccClassID = ac.ClassID
inner join AccType at on at.TypeID = a.AccTypeID
ORDER BY [AccNumber]"
                            UpdateCommand="UPDATE [Account] SET [AccNumber] = @AccNumber
                            ,[Name] = @Name
, [AccTypeID] = (SELECT TypeID from AccType where Type = @Type)
, [IsDebit] = (CASE WHEN @IsDebit = 'Yes' then 1 else 0 end)
, [AccClassID] = (SELECT ClassID from AccClass where Class = @Class)
 WHERE [AccountID] = @AccountID">
                            <DeleteParameters>
                                <asp:Parameter Name="AccountID" Type="Int32" />
                            </DeleteParameters>
                            <InsertParameters>
                                <asp:Parameter Name="AccNumber" Type="Int32" />
                                <asp:Parameter Name="Name" Type="String" />
                                <asp:Parameter Name="Desc" Type="String" />
                                <asp:Parameter Name="IsActive" Type="Boolean" />
                                <asp:Parameter Name="AccTypeID" Type="Int32" />
                                <asp:Parameter Name="IsDebit" Type="Boolean" />
                                <asp:Parameter Name="AccClassID" Type="Int32" />
                                <asp:Parameter Name="SortOrder" Type="Int32" />
                                <asp:Parameter Name="Cre_Date" Type="DateTime" />
                                <asp:Parameter Name="Cre_User" Type="Int32" />
                                <asp:Parameter Name="Balance" Type="Decimal" />
                            </InsertParameters>
                            <UpdateParameters>
                                <asp:Parameter Name="AccNumber" Type="Int32" />
                                <asp:Parameter Name="Name" Type="String" />
                                <asp:Parameter Name="Type" Type="String" />
                                <asp:Parameter Name="IsDebit" Type="String" />
                                <asp:Parameter Name="Class" Type="String" />
                            </UpdateParameters>
                        </asp:SqlDataSource>
                        <asp:SqlDataSource ID="SqlDataSource2" runat="server" ConnectionString="<%$ ConnectionStrings:TransactionDB %>" SelectCommand="SELECT DISTINCT [Type] FROM [AccType]"></asp:SqlDataSource>
                        <asp:SqlDataSource ID="SqlDataSource3" runat="server" ConnectionString="<%$ ConnectionStrings:TransactionDB %>" SelectCommand="SELECT DISTINCT [Class] FROM [AccClass]"></asp:SqlDataSource>
                        <asp:SqlDataSource ID="SqlDataSource4" runat="server" ConnectionString="<%$ ConnectionStrings:TransactionDB %>" SelectCommand="SELECT * FROM [AccType]"></asp:SqlDataSource>
                        <asp:SqlDataSource ID="SqlDataSource5" runat="server" ConnectionString="<%$ ConnectionStrings:TransactionDB %>" SelectCommand="SELECT * FROM [AccClass]"></asp:SqlDataSource>

                    </div>
                </div>
            </div>
        </div>
    </div>
</asp:Content>
