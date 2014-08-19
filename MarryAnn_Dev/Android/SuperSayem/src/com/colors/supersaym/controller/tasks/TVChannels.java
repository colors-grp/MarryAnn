package com.colors.supersaym.controller.tasks;

import java.util.ArrayList;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.content.SharedPreferences;

import com.colors.supersaym.controller.communication.Communication;
import com.colors.supersaym.controller.communication.RequestHeader;
import com.colors.supersaym.controller.communication.ResponseObject;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.controller.communication.Task.TaskID;
import com.colors.supersaym.dataobjects.ChannelData;
import com.colors.supersaym.dataobjects.GuideData;
import com.colors.supersaym.dataobjects.UserData;
import com.colors.supersaym.dataprovider.DataRequestor;
import com.colors.supersaym.storage.Constants;
import com.colors.supersaym.storage.UIManager;

public class TVChannels extends Task {
	private String url;
	Context mxontext;
	private ResponseObject response;
	public static String CONTENT_TYPE_KEY = "Content-type";
	public static String ACCESS_TOKEN_KEY = "accessToken";
	public static String CONTENT_TYPE_VALUE = "application/x-www-form-urlencoded";
	ArrayList<ChannelData> channelList;
	public TVChannels (DataRequestor requestor,Context context,String programId) {
		setRequestor(requestor);

		setId(TaskID.TVChannelsTask);
		channelList=new ArrayList<ChannelData>();
		this.mxontext = context;
		url = Communication.Base_URL + "/tv_channels/format/json/programId/"+programId;
		url = url.replaceAll("\\s+", "");
	}
	@Override
	public void execute() {
		response = (ResponseObject) Communication.getMethod(url,
				getHeadersList(), mxontext);

		System.out.println("url" + url);
		mapServerError(response.getStatusCode());
		String r = response.getResponseString();
		JSONObject mainObject;
		try {
			mainObject = new JSONObject(r);
			int size = mainObject.getInt("size");
			for (int i = 0; i < size; i++) {
				JSONObject tempObject = mainObject.getJSONObject(i + "");
				ChannelData data = ChannelData.channelFromJson(tempObject);
				channelList.add(data);
			}

		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}		
	}

	public Object getResult() {
		return channelList;
	}

	public ArrayList<RequestHeader> getHeadersList() {
		ArrayList<RequestHeader> headers = new ArrayList<RequestHeader>();
		RequestHeader header = new RequestHeader(CONTENT_TYPE_KEY,
				CONTENT_TYPE_VALUE);
		headers.add(header);

		return headers;
	}

}
