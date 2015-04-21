<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="ManageAccount.aspx.cs" Inherits="AccountingJournal.Financial_Statement.InActiveAccount" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group text-center">
            <div class="panel-heading">
                Manage Accounts
            </div>
            <div class="panel-body">
                <div class="container" style="width: 100%; height:500px;overflow:auto;">
<%--                    <form runat="server">--%>
                        <asp:GridView ID="GridView1" runat="server" DataKeyNames="AccountID" AutoGenerateColumns="False"
                            Style="margin-left: auto; margin-right: auto" CssClass="table" CellPadding="4" ForeColor="#333333"
                            GridLines="None">
                            <AlternatingRowStyle BackColor="White" />
                            <Columns>
                                <asp:TemplateField HeaderText="Activation">
                                    <EditItemTemplate>
                                        <asp:CheckBox ID="chkStatus" runat="server" />
                                    </EditItemTemplate>
                                    <ItemTemplate>
                                        <asp:CheckBox ID="chkStatus" runat="server" AutoPostBack="true" OnCheckedChanged="chkStatus_OnCheckedChanged"
                                            Checked='<%# Convert.ToBoolean(Eval("IsActive")) %>'/>
                                    </ItemTemplate>
                                </asp:TemplateField>

                                <asp:BoundField DataField="Account Name" HeaderText="Account Name" SortExpression="Account Name" HeaderStyle-Width="350px" ItemStyle-HorizontalAlign="Left">
                                    <HeaderStyle Width="350px"></HeaderStyle>

                                    <ItemStyle HorizontalAlign="Left"></ItemStyle>
                                </asp:BoundField>
                                <asp:BoundField DataField="AccNumber" HeaderText="Account Number" SortExpression="AccNumber" />
                                <asp:BoundField DataField="Cre_Date" DataFormatString="{0:MM/dd/yyyy}" HeaderText="Create Date" SortExpression="Cre_Date" />
                                <asp:BoundField DataField="Balance" DataFormatString="{0:#,##0.00}" HeaderText="Balance" SortExpression="Balance">
                                    <ItemStyle HorizontalAlign="Right" />
                                </asp:BoundField>
                                <asp:BoundField DataField="NormalBalance" HeaderText="Normal Balance" SortExpression="NormalBalance" />
                                <asp:BoundField DataField="AccountType" HeaderText="Account Type" SortExpression="AccountType" />
                            </Columns>
                            <EditRowStyle BackColor="#2461BF" />
                            <FooterStyle BackColor="#507CD1" Font-Bold="True" ForeColor="White" />
                            <HeaderStyle BackColor="Gray" Font-Bold="True" ForeColor="White" />
                            <PagerStyle BackColor="#2461BF" ForeColor="White" HorizontalAlign="Center" />
                            <RowStyle BackColor="#EFF3FB" />
                            <SelectedRowStyle BackColor="#D1DDF1" Font-Bold="True" ForeColor="#333333" />
                            <SortedAscendingCellStyle BackColor="#F5F7FB" />
                            <SortedAscendingHeaderStyle BackColor="#6D95E1" />
                            <SortedDescendingCellStyle BackColor="#E9EBEF" />
                            <SortedDescendingHeaderStyle BackColor="#4870BE" />
                        </asp:GridView>
                    <%--</form>--%>
                </div>
            </div>
        </div>
    </div>
</asp:Content>

