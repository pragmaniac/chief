@extends('chief::back._layouts.mail')

@section('preheader')
    @lang('chief::mails.invitation.header') {{ chiefSetting('client.app_name') }}.
@endsection

@section('title')
    @lang('chief::mails.invitation.title') {{ chiefSetting('client.app_name') }}.
@endsection

@section('content')
    <tr>
        <td bgcolor="#ffffff" align="left" style="padding: 0px 50px 25px 50px; color: #808080; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
            <p style="margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 21px;">
                @lang('chief::mails.invitation.content', ['inviter' => $inviter->firstname, 'appname' => chiefSetting('client.app_name')])
            </p>

            <p style="margin: 40px 0 20px 0;">
                @include('chief::back.mails._button',[
                'url' => $accept_url,
                'label' => trans('chief::mails.invitation.accept'),
            ])
            </p>

            <p style="margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 10px; font-weight: 100; line-height: 12px;">
                @lang('chief::mails.invitation.mistake', ['link' => $deny_url])
            </p>

        </td>
    </tr>

@endsection
