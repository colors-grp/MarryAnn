package com.colors.supersaym;

import java.util.ArrayList;
import java.util.HashMap;

import com.colors.supersaym.Views.GuideActivity;
import com.colors.supersaym.dataobjects.ChannelData;
import com.colors.supersaym.dataobjects.GuideData;

import android.app.Activity;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;


public class ChannelsAdapter extends BaseAdapter {
    
    private Activity activity;
    private ArrayList<ChannelData> data;
    private static LayoutInflater inflater=null;
    public ImageLoader imageLoader; 
    

    public ChannelsAdapter(Activity a, ArrayList<ChannelData> d) {
        activity = a;
        data=d;
        inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        imageLoader=new ImageLoader(activity.getApplicationContext());
    }

    public int getCount() {
    	Log.v("data size", data.size()+"");
        return data.size();
    }

    public Object getItem(int position) {
        return position;
    }

    public long getItemId(int position) {
        return position;
    }
    
    public View getView(int position, View convertView, ViewGroup parent) {
        View vi=convertView;
        if(convertView==null)
            vi = inflater.inflate(R.layout.channel_item, null);

        TextView name = (TextView)vi.findViewById(R.id.title); // title
        TextView time = (TextView)vi.findViewById(R.id.time); // title

        ChannelData dataChannel = new ChannelData();
        dataChannel = data.get(position);
        
        // Setting all values in listview
        name.setText(dataChannel.channel);
        time.setText(dataChannel.time);
        return vi;
    }
}