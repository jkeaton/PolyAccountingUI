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
                <table class="table table-bordered table-hover">
                    <%--<asp:Label ID="ChrAsset" runat="server"></asp:Label>--%>
                    <tr>
                        <td>
                            <form runat="server">
                                <asp:GridView ID="GridView1" runat="server" DataKeyNames="AccountID" AutoGenerateColumns="False"  style="margin-left:auto; margin-right:auto">
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

                                        <asp:BoundField DataField="Account Name" HeaderText="Account Name" SortExpression="Account Name" HeaderStyle-Width="400px" ItemStyle-HorizontalAlign="Left">
                                            <HeaderStyle Width="400px"></HeaderStyle>

                                            <ItemStyle HorizontalAlign="Left"></ItemStyle>
                                        </asp:BoundField>
                                        <asp:BoundField DataField="AccNumber" HeaderText="Account Number" SortExpression="AccNumber" />
                                        <asp:BoundField DataField="Cre_Date" DataFormatString="{0:MM/dd/yyyy}" HeaderText="Create Date" SortExpression="Cre_Date" />
                                        <asp:BoundField DataField="Balance" DataFormatString="{0:#,##0.00}" HeaderText="Balance" SortExpression="Balance" />
                                        <asp:BoundField DataField="NormalBalance" HeaderText="Normal Balance" SortExpression="NormalBalance" />
                                        <asp:BoundField DataField="AccountType" HeaderText="Account Type" SortExpression="AccountType" />
                                    </Columns>
                                </asp:GridView>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</asp:Content>


