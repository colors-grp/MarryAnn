package com.colors.supersaym.controller.tasks;

import java.util.ArrayList;
import java.util.Iterator;

import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.util.Log;

import com.colors.supersaym.controller.communication.Communication;
import com.colors.supersaym.controller.communication.RequestHeader;
import com.colors.supersaym.controller.communication.ResponseObject;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.controller.communication.Task.TaskID;
import com.colors.supersaym.dataobjects.GuideData;
import com.colors.supersaym.dataobjects.UserData;
import com.colors.supersaym.dataprovider.DataRequestor;
import com.colors.supersaym.storage.UIManager;

public class GuideTask extends Task {
	private String url;
	Context mxontext;
	private ResponseObject response;
	public static String CONTENT_TYPE_KEY = "Content-type";
	public static String ACCESS_TOKEN_KEY = "accessToken";
	public static String CONTENT_TYPE_VALUE = "application/x-www-form-urlencoded";
	ArrayList<GuideData> GuideList;
	private Object result;

	public GuideTask(DataRequestor requestor, Context context) {
		setRequestor(requestor);

		setId(TaskID.GuideTask);
		GuideList = new ArrayList<GuideData>();
		this.mxontext = context;
		url = Communication.Base_URL + "/tv_guide/format/json";

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
			Iterator iter = mainObject.keys();
			while (iter.hasNext()) {
				String key = (String) iter.next();
				GuideData data = GuideData.guideFromJson(mainObject
						.getJSONObject(key));
				GuideList.add(data);
			}
			result=GuideList;

		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}

	@Override
	public Object getResult() {
		return GuideList;
	}

	public ArrayList<RequestHeader> getHeadersList() {
		ArrayList<RequestHeader> headers = new ArrayList<RequestHeader>();
		RequestHeader header = new RequestHeader(CONTENT_TYPE_KEY,
				CONTENT_TYPE_VALUE);
		headers.add(header);

		return headers;
	}

}
